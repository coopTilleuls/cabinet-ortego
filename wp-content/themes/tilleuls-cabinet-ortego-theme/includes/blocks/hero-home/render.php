<?php
declare(strict_types=1);

if ( ! function_exists( 'render_hero_home_block' ) ) {
    function render_hero_home_block( array $attributes, string $content ): string
    {
        $wrapper_attributes = 'class="hero alignfull" id="accueil"';

        ob_start();
        $template_path = locate_template( 'patterns/hero-home.php');
        if ($template_path) {
            error_log('Template "patterns/hero-home.php" trouvé');
            include $template_path;
        } else {
            error_log('Template "patterns/hero-home.php" introuvable');
        }
        return ob_get_clean();
    }
}
