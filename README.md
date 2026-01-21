# Cabinet Ortego Sampedro

This project was for the lawer cabinet

## Requirements
- PHP 8.0 or higher
- MySQL version 8.0 or higher or MariaDB version 10.5 or higher
- [Castor](https://github.com/jolicode/castor)

## Installation
First, you need to change edit `.env.example` to `.env` file and provide some information to the script for the creation of the WordPress environment.

The script needs to have the path `$HOME/.local/bin` into your `$PATH` because `wp-cli` will be installed there.  
If it is not, add the following line in your `.bashrc` or `.zschrc` : `export PATH="$HOME/.local/bin:$PATH"`

To start the installation script : `castor install --path .`.

## Start WordPress
To start WordPress, run : `wp server`

## Configuration

You can add this code in your `wp-config.php` in order to use symfony var-dumper and retrieve env variables from the php code.
```php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();
```
