<?php
declare(strict_types=1);

if ( ! function_exists( 'register_hero_home_block' ) ) {

    function register_hero_home_block(): void
    {
        register_block_type(
            'tilleuls-ortego/hero-home',
            [
                'render_callback' => 'render_hero_home_block',
                'supports'        => [
                    'align' => [ 'full' ],
                ],
            ]
        );
    }
}
