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

    run("wp plugin auto-updates enable --all", context: $context);
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
