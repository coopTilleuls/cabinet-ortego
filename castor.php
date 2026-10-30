<?php

use Castor\Attribute\AsTask;
use Castor\Context;

use function Castor\context;
use function Castor\fs;
use function Castor\http_download;
use function Castor\io;
use function Castor\load_dot_env;
use function Castor\run;

// Keep the process in the project root: .env and wp-cli.phar are resolved relative to it, not to --path.
defined('CASTOR_USE_CHDIR') || define('CASTOR_USE_CHDIR', false);

const WP_LOCALE = 'fr_FR';
const WP_PLUGINS = ['contact-form-7', 'wordpress-seo', 'polylang'];
// Single source of truth for the site pages, also read by the theme header to build the navigation.
const THEME_PAGES = 'wp-content/themes/tilleuls-cabinet-ortego-theme/pages.json';
// Old custom block names => new names (blocks renamed for consistency). Used by `castor migrate-blocks` and `castor update`.
const BLOCK_RENAMES = [
    'tilleuls-ortego-blocks/banner-colored' => 'tilleuls-ortego-blocks/association-banner',
    'tilleuls-ortego-blocks/block-citation' => 'tilleuls-ortego-blocks/quote',
    'tilleuls-ortego-blocks/block-column-with-img' => 'tilleuls-ortego-blocks/text-image',
    'tilleuls-ortego-blocks/block-contact-column' => 'tilleuls-ortego-blocks/contact-column',
    'tilleuls-ortego-blocks/block-cta' => 'tilleuls-ortego-blocks/call-to-action',
    'tilleuls-ortego-blocks/block-hero-homepage' => 'tilleuls-ortego-blocks/hero-home',
    'tilleuls-ortego-blocks/block-info-column' => 'tilleuls-ortego-blocks/info-box',
    'create-block/block-meeting-calendly' => 'tilleuls-ortego-blocks/appointment',
    'tilleuls-ortego-blocks/block-pricing' => 'tilleuls-ortego-blocks/pricing',
    'tilleuls-ortego-blocks/block-profile-homepage' => 'tilleuls-ortego-blocks/profile-home',
    'tilleuls-ortego-blocks/profile-block' => 'tilleuls-ortego-blocks/profile',
    'tilleuls-ortego-blocks/section-card' => 'tilleuls-ortego-blocks/cards',
    'tilleuls-ortego-blocks/title-section' => 'tilleuls-ortego-blocks/section-title',
];

#[AsTask(description: 'Install wordpress with plugins')]
function install(string $path = '.', string $wpVersion = 'latest'): void
{
    io()->title("Installation of WordPress for Cabinet Ortego");

    $context = site_context($path);
    if ($context === null || !ensure_wp_cli($context)) {
        return;
    }

    // Test if a WordPress installation exists
    $wp_installation = run('wp core is-installed', context: $context->withQuiet());
    if ($wp_installation->isSuccessful()) {
        io()->info('A wordpress installation already exists. Run `castor update` to upgrade it.');
        return;
    }

    // Make the installation
    io()->info("Starting installation of WordPress environment");
    run(['wp', 'core', 'download', '--locale='.WP_LOCALE, '--skip-content', '--version='.$wpVersion], context: $context);

    // create config if there is no one
    $wp_config = run('wp config path', context: $context->withQuiet());
    if (! $wp_config->isSuccessful()) {
        run('wp config create --dbname=$DB_NAME --dbuser=$DB_USER --dbpass=$DB_PASSWORD --dbhost=$DB_HOST --dbprefix=$DB_PREFIX', context: $context);
    }

    $db_exists = run("wp db check", context: $context->withQuiet())->isSuccessful();
    if ( !$db_exists ) {
        run('wp db create', context: $context);
    }

    run('wp core install --locale='.WP_LOCALE.' --url=$WP_URL --title="$WP_TITLE" --admin_user=$WP_ADMIN_USER --admin_password=$WP_ADMIN_PASSWORD --admin_email=$WP_ADMIN_EMAIL', context: $context);

    io()->info("Core installed.".PHP_EOL."Installing required plugins...");
    run(['wp', 'plugin', 'install', ...WP_PLUGINS, '--activate'], context: $context);
    run('wp plugin activate tilleuls', context: $context);
    run('wp theme activate tilleuls-cabinet-ortego-theme', context: $context);

    run("wp plugin auto-updates enable --all", context: $context);

    run(['wp', 'rewrite', 'structure', '/%postname%/'], context: $context);
    create_pages($context, $path);
}

#[AsTask(description: 'Create the site pages declared in the theme (pages.json), skipping existing ones')]
function pages(string $path = '.'): void
{
    io()->title("Pages of Cabinet Ortego");

    $context = installed_site_context($path);
    if ($context === null) {
        return;
    }

    create_pages($context, $path);
}

#[AsTask(name: 'migrate-blocks', description: 'Rename old custom block names in the content (pages, templates, patterns)')]
function migrate_blocks(string $path = '.', bool $dryRun = false): void
{
    io()->title("Block names migration");

    $context = installed_site_context($path);
    if ($context === null) {
        return;
    }

    rename_blocks($context, $dryRun);
}

/**
 * Rewrite block comment delimiters (`<!-- wp:old ...`, `<!-- /wp:old -->`) in post_content.
 * Idempotent: once migrated, the old names are no longer found.
 */
function rename_blocks(Context $context, bool $dryRun = false): void
{
    foreach (BLOCK_RENAMES as $old => $new) {
        $command = ['wp', 'search-replace', 'wp:'.$old.' ', 'wp:'.$new.' ', '--include-columns=post_content', '--report-changed-only'];
        if ($dryRun) {
            $command[] = '--dry-run';
        }
        run($command, context: $context);
    }
}

function create_pages(Context $context, string $path): void
{
    // Prefer the theme of the target install, fall back to the one in this repository.
    $file = fs()->exists($path.'/'.THEME_PAGES) ? $path.'/'.THEME_PAGES : __DIR__.'/'.THEME_PAGES;
    $pages = json_decode((string) file_get_contents($file), true, flags: JSON_THROW_ON_ERROR);

    foreach ($pages as $page) {
        $id = trim(run(
            ['wp', 'post', 'list', '--post_type=page', '--post_status=any', '--name='.$page['slug'], '--field=ID'],
            context: $context->withQuiet()
        )->getOutput());

        if ($id === '') {
            $id = trim(run(
                ['wp', 'post', 'create', '--post_type=page', '--post_status=publish', '--post_title='.$page['title'], '--post_name='.$page['slug'], '--porcelain'],
                context: $context->withQuiet()
            )->getOutput());
            io()->writeln(sprintf('Created page "%s" (#%s)', $page['title'], $id));
        } else {
            io()->writeln(sprintf('Page "%s" already exists (#%s)', $page['title'], $id));
        }

        if (!empty($page['front']) && $id !== '') {
            run(['wp', 'option', 'update', 'show_on_front', 'page'], context: $context->withQuiet());
            run(['wp', 'option', 'update', 'page_on_front', $id], context: $context->withQuiet());
        }
    }

    io()->success('Pages ready.');
}

#[AsTask(description: 'Update WordPress core, database, plugins and translations')]
function update(string $path = '.', string $wpVersion = 'latest'): void
{
    io()->title("Update of WordPress for Cabinet Ortego");

    $context = installed_site_context($path);
    if ($context === null) {
        return;
    }

    $before = trim(run('wp core version', context: $context->withQuiet())->getOutput());

    $core_update = ['wp', 'core', 'update', '--locale='.WP_LOCALE];
    if ($wpVersion !== 'latest') {
        // --force allows downgrading or reinstalling a given version
        array_push($core_update, '--version='.$wpVersion, '--force');
    }
    if (!run($core_update, context: $context)->isSuccessful()) {
        io()->error('Core update failed.');
        return;
    }

    run('wp core update-db', context: $context);
    rename_blocks($context);
    run('wp plugin update --all', context: $context);
    run('wp language core update', context: $context);
    run('wp language plugin update --all', context: $context);
    run('wp language theme update --all', context: $context);
    // New or changed custom post types (expertise, union) need fresh rewrite rules
    run('wp rewrite flush', context: $context);

    $after = trim(run('wp core version', context: $context->withQuiet())->getOutput());
    io()->success(sprintf('WordPress %s → %s', $before, $after));
    io()->note('Rebuild the blocks if needed: cd wp-content/plugins/tilleuls && yarn build');
}

function site_context(string $path): ?Context
{
    if (!fs()->exists('.env')) {
        io()->error('.env file not found');
        return null;
    }

    if (!fs()->exists($path)) {
        fs()->mkdir($path);
    }

    return context()->withEnvironment(load_dot_env())->withWorkingDirectory($path)->withAllowFailure();
}

/**
 * Context for an existing WordPress install: wp-cli available and WordPress installed (database reachable).
 */
function installed_site_context(string $path): ?Context
{
    $context = site_context($path);
    if ($context === null || !ensure_wp_cli($context)) {
        return null;
    }

    if (!run('wp core is-installed', context: $context->withQuiet())->isSuccessful()) {
        io()->error('No WordPress installation found (or database unreachable). Run `castor install` first.');
        return null;
    }

    return $context;
}

function ensure_wp_cli(Context $context): bool
{
    if (run('wp cli', context: $context->withQuiet())->isSuccessful()) {
        return true;
    }

    io()->info('wp cli is not installed'.PHP_EOL.'Installation...');

    http_download('https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar', './wp-cli.phar');
    $result = run(['php', 'wp-cli.phar', '--info']);
    if (!$result->isSuccessful()) {
        io()->error('Error during the installation of wp cli');
        fs()->remove('wp-cli.phar');
        return false;
    }
    fs()->chmod('wp-cli.phar', 0755);
    fs()->copy('./wp-cli.phar', getenv('HOME').'/.local/bin/wp');
    fs()->remove('./wp-cli.phar');
    io()->success('wp cli installation complete');

    // If WP has not been added to $PATH
    if (!run('wp cli', context: $context->withQuiet())->isSuccessful()) {
        io()->error('$HOME/.local/bin has not been added to your $PATH.\n Add the following line to your .bashrc or .zschrc : \'export PATH="$HOME/.local/bin:$PATH"\'');
        return false;
    }

    return true;
}
