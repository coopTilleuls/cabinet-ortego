<?php

/**
 * Title: Header
 * Slug: tilleuls-cabinet-ortego-theme/header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Site header with site title and navigation.
 *
 * @package tilleuls-cabinet-ortego-theme
 * @since tilleuls-cabinet-ortego-theme 1.0
 */

$title = tilleuls_split_title(get_bloginfo('name'));

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
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <?php echo esc_html($title['first']); ?>
                        <span> <?php echo esc_html($title['last']); ?></span>
                    </a>
                </p>
            <!-- /wp:html -->

            <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
            <div class="wp-block-group">
                <!-- wp:navigation {"overlayMenu":"mobile","layout":{"type":"flex","justifyContent":"right"}} -->
                <?php echo tilleuls_navigation_links(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- serialized block markup: attributes are JSON-encoded by serialize_block_attributes() and escaped by core/navigation-link at render. ?>
                <!-- /wp:navigation -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->
