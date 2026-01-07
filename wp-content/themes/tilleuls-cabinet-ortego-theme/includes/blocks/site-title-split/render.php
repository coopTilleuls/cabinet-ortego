<?php

declare(strict_types=1);

$site_name = get_bloginfo('name');
$parts = explode(' ', $site_name, 2);

$first = esc_html($parts[0]);
$rest = isset($parts[1]) ? esc_html($parts[1]) : '';
?>

<p class="wp-block-site-title">
    <a href="http://localhost:8080" target="_self" rel="home" aria-current="page">
        <?php
        echo $first; ?>
        <?php
        if ($rest) : ?>
            <span class="site-title__rest"><?php
                echo $rest; ?></span>
        <?php
        endif; ?>
    </a>
</p>
