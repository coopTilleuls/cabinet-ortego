<?php

declare(strict_types=1);

require_once  __DIR__ . '/hero-home/register.php';
require_once  __DIR__ . '/hero-home/render.php';


if (!function_exists('tilleuls_register_php_block')) {
    /**
     * Register the blocks that require php to be rendered
     *
     * @return void
     */
   function tilleuls_register_php_block(): void
   {
       register_hero_home_block();
   }
}

add_action('init', 'tilleuls_register_php_block');
