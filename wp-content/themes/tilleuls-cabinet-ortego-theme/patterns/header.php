<?php

/**
 * Title: Header
 * Slug: tilleuls-cabinet-ortego-theme/header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Site header with site title and navigation.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since tilleuls-cabinet-ortego-theme 1.0
 */

$title = get_bloginfo('title');

function explode_title(string $title): array
{
    $exploded_title = explode(' ', $title);

    return [
            'first' => array_shift($exploded_title),
            'last' => implode(' ', $exploded_title)
    ];
}

?>
<!-- wp:group {"align":"full","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull">
    <!-- wp:group {"layout":{"type":"constrained"}} -->
    <div class="wp-block-group">
        <!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
        <div class="wp-block-group alignwide"
             style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)">
            <!-- wp:html -->
                <p class="wp-block-site-title">
                    <a href="">
                        <?php echo wp_kses_post( explode_title($title)['first'] ); ?>
                        <span> <?php echo wp_kses_post( explode_title($title)['last'] ); ?></span>
                    </a>
                </p>
            <!-- /wp:html -->

            <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
            <div class="wp-block-group">
                <!-- wp:navigation {"layout":{"type":"flex","justifyContent":"right"}} /-->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->
