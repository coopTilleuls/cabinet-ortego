<?php

use Castor\Attribute\AsTask;
use Castor\Context;

use function Castor\context;
use function Castor\fs;
use function Castor\http_download;
use function Castor\io;
use function Castor\load_dot_env;
use function Castor\run;

const WP_LOCALE = 'fr_FR';
const WP_PLUGINS = ['contact-form-7', 'wordpress-seo', 'polylang'];
// Single source of truth for the site pages, also read by the theme header to build the navigation.
const THEME_PAGES = 'wp-content/themes/tilleuls-cabinet-ortego-theme/pages.json';

#[AsTask(description: 'Install wordpress with plugins')]
function install(string $path = '.', string $version = 'latest'): void
{
    io()->title("Installation of WordPress for Cabinet Ortego");

    $context = wp_context($path);
    if ($context === null || !ensure_wp_cli($context)) {
        return;
    }

    // Test if a WordPress installation exists
    $wp_installation = run('wp core is-installed', context: $context->withQuiet());
    if($wp_installation->isSuccessful()) {
        io()->info('A wordpress installation already exists. Run `castor update` to upgrade it.');
        return;
    }

    // Make the installation
    io()->info("Starting installation of WordPress environment");
    run(['wp', 'core', 'download', '--locale='.WP_LOCALE, '--skip-content', '--version='.$version], context: $context);

    // create config if there is no one
    $wp_config = run('wp config path', context: $context->withQuiet());
    if (! $wp_config->isSuccessful()) {
        run('wp config create --dbname=$DB_NAME --dbuser=$DB_USER --dbpass=$DB_PASSWORD --dbhost=$DB_HOST --dbprefix=$DB_PREFIX', context: $context);
    }

    $db_exists = run("wp db check", context: $context->withQuiet())->isSuccessful();
    if( !$db_exists ) {
        run('wp db create', context: $context);
    }

    run('wp core install --locale='.WP_LOCALE.' --url=$WP_URL --title="$WP_TITLE" --admin_user=$WP_ADMIN_USER --admin_password=$WP_ADMIN_PASSWORD --admin_email=$WP_ADMIN_EMAIL', context: $context);

    io()->info("Core installed.".PHP_EOL."Installing required plugins...");
    run(['wp', 'plugin', 'install', ...WP_PLUGINS, '--activate'], context: $context);
    run('wp plugin activate tilleuls', context: $context);
    run('wp theme activate tilleuls-cabinet-ortego-theme', context: $context);

    run("wp plugin auto-updates enable --all", context: $context);

    run(['wp', 'rewrite', 'structure', '/%postname%/'], context: $context);
    create_pages($context);
}

#[AsTask(description: 'Create the site pages declared in the theme (pages.json), skipping existing ones')]
function pages(string $path = '.'): void
{
    io()->title("Pages of Cabinet Ortego");

    $context = wp_context($path);
    if ($context === null || !ensure_wp_cli($context)) {
        return;
    }

    if (!run('wp core is-installed', context: $context->withQuiet())->isSuccessful()) {
        io()->error('No WordPress installation found (or database unreachable). Run `castor install` first.');
        return;
    }

    create_pages($context);
}

function create_pages(Context $context): void
{
    $pages = json_decode((string) file_get_contents(__DIR__.'/'.THEME_PAGES), true, flags: JSON_THROW_ON_ERROR);

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
function update(string $path = '.', string $version = 'latest'): void
{
    io()->title("Update of WordPress for Cabinet Ortego");

    $context = wp_context($path);
    if ($context === null || !ensure_wp_cli($context)) {
        return;
    }

    if (!run('wp core is-installed', context: $context->withQuiet())->isSuccessful()) {
        io()->error('No WordPress installation found (or database unreachable). Run `castor install` first.');
        return;
    }

    $before = trim(run('wp core version', context: $context->withQuiet())->getOutput());

    $core_update = ['wp', 'core', 'update', '--locale='.WP_LOCALE];
    if ($version !== 'latest') {
        // --force allows downgrading or reinstalling a given version
        array_push($core_update, '--version='.$version, '--force');
    }
    if (!run($core_update, context: $context)->isSuccessful()) {
        io()->error('Core update failed.');
        return;
    }

    run('wp core update-db', context: $context);
    run('wp plugin update --all', context: $context);
    run('wp language core update', context: $context);
    run('wp language plugin update --all', context: $context);
    run('wp language theme update --all', context: $context);

    $after = trim(run('wp core version', context: $context->withQuiet())->getOutput());
    io()->success(sprintf('WordPress %s → %s', $before, $after));
    io()->note('Rebuild the blocks if needed: cd wp-content/plugins/tilleuls && npm run build');
}

function wp_context(string $path): ?Context
{
    if(!fs()->exists('.env')) {
        io()->error('.env file not found');
        return null;
    }

    if(!fs()->exists($path)) {
        fs()->mkdir($path);
    }

    return context()->withEnvironment(load_dot_env())->withWorkingDirectory($path)->withAllowFailure();
}

function ensure_wp_cli(Context $context): bool
{
    if (run('wp cli', context: $context->withQuiet())->isSuccessful()) {
        return true;
    }

    io()->info('wp cli is not installed'.PHP_EOL.'Installation...');

    http_download('https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar', './wp-cli.phar');
    $result = run(['php', 'wp-cli.phar', '--info']);
    if(!$result->isSuccessful()) {
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
