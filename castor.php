<?php

use Castor\Attribute\AsTask;

use function Castor\context;
use function Castor\fs;
use function Castor\http_client;
use function Castor\http_download;
use function Castor\io;
use function Castor\load_dot_env;
use function Castor\run;

#[AsTask(description: 'Install wordpress with plugins')]
function install(string $path = '.', string $token = ''): void
{
    io()->title("Installation of WordPress for Cabinet Ortego");

    if(!fs()->exists('.env')) {
        io()->error('.env file not found');
        return;
    }

    if(!fs()->exists($path)) {
        fs()->mkdir($path);
    }

    $context = context()->withEnvironment(load_dot_env())->withWorkingDirectory($path)->withAllowFailure();

    $wp_cli_installed = run('wp cli', context: $context->withQuiet());
    if(!$wp_cli_installed->isSuccessful()) {
        io()->info('wp cli is not installed'.PHP_EOL.'Installation...');

        http_download('https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar', './wp-cli.phar');
        $result = run(['php', 'wp-cli.phar', '--info']);
        if(!$result->isSuccessful()) {
            io()->error('Error during the installation of wp cli');
            fs()->remove('wp-cli.phar');
            return;
        }
        fs()->chmod('wp-cli.phar', 0755);
        fs()->copy('./wp-cli.phar', getenv('HOME').'/.local/bin/wp');
        fs()->remove('./wp-cli.phar');
        io()->success('wp cli installation complete');

        // If WP has not been added to $PATH
        $wp_cli_installed = run('wp cli', context: $context->withQuiet());
        if(!$wp_cli_installed->isSuccessful()) {
            io()->error('$HOME/.local/bin has not been added to your $PATH.\n Add the following line to your .bashrc or .zschrc : \'export PATH="$HOME/.local/bin:$PATH"\'');
            return;
        }
    }

    // Test if a WordPress installation exists
    $wp_installation = run('wp core is-installed', context: $context->withQuiet());
    if($wp_installation->isSuccessful()) {
        io()->info('A wordpress installation already exists.');
        return;
    }

    // Make the installation
    io()->info("Starting installation of WordPress environment");
    run('wp core download --locale=fr_FR --skip-content', context: $context);

    // create config if there is no one
    $wp_config = run('wp config path', context: $context->withQuiet());
    if (! $wp_config->isSuccessful()) {
        run('wp config create --dbname=$DB_NAME --dbuser=$DB_USER --dbpass=$DB_PASSWORD --dbhost=$DB_HOST --dbprefix=$DB_PREFIX', context: $context);
    }

    $db_exists = run("wp db check", context: $context->withQuiet())->isSuccessful();
    if( !$db_exists ) {
        run('wp db create', context: $context);
    }

    run('wp core install --locale=fr_FR --url=$WP_URL --title="$WP_TITLE" --admin_user=$WP_ADMIN_USER --admin_password=$WP_ADMIN_PASSWORD --admin_email=$WP_ADMIN_EMAIL', context: $context);

    io()->info("Core installed.".PHP_EOL."Installing required plugins...");
    run("wp plugin install contact-form-7 wordpress-seo --activate", context: $context);

    run("wp plugin auto-updates enable --all", context: $context);
}
