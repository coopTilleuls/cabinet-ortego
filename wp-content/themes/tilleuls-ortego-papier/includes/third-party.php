<?php
/**
 * Blocked third-party content: the plugin blocks embed Calendly and Google Maps directly. This theme
 * swaps those embeds for a consent placeholder; assets/js/consent.js loads them only after consent.
 * Without JavaScript the visitor keeps a direct link (Calendly, itinerary) and the phone number.
 */

declare(strict_types=1);

/**
 * @param 'calendly'|'map' $service
 */
function tilleuls_papier_embed_placeholder(string $service, string $src, string $frame_title = ''): string
{
    $contact = tilleuls_papier_contact();
    $is_calendly = 'calendly' === $service;
    $address = $contact['address'];
    $direct_url = $is_calendly
        ? $src
        : add_query_arg(['api' => 1, 'destination' => rawurlencode($address)], 'https://www.google.com/maps/dir/');
    $new_tab = '<span class="screen-reader-text">' . esc_html__('(site externe, nouvel onglet)', 'tilleuls-ortego-papier') . '</span>'
        . tilleuls_papier_icon('external');
    $phone = $contact['phone']
        ? '<a href="' . esc_attr(tilleuls_papier_tel_href($contact['phone'])) . '">'
            . '<span class="screen-reader-text">' . esc_html__('Appeler le', 'tilleuls-ortego-papier') . ' </span>'
            . esc_html($contact['phone']) . '</a>'
        : '';

    ob_start();
    ?>
    <div class="embed-consent embed-consent--<?php echo esc_attr($service); ?>" data-embed="<?php echo esc_attr($service); ?>"
         data-src="<?php echo esc_url($src); ?>" data-title="<?php echo esc_attr($frame_title); ?>">
        <div class="embed-consent__intro" data-embed-intro>
            <h3 class="embed-consent__title">
                <?php echo $is_calendly ? esc_html__('Agenda en ligne', 'tilleuls-ortego-papier') : esc_html__("Carte d'accès", 'tilleuls-ortego-papier'); ?>
            </h3>
            <p>
                <?php
                echo $is_calendly
                    ? esc_html__("L'agenda est fourni par Calendly, un service externe qui dépose des cookies. Il ne se charge que si vous l'affichez.", 'tilleuls-ortego-papier')
                    : esc_html__("La carte est fournie par un service externe qui dépose des cookies. L'adresse ci-dessus suffit pour vous rendre au cabinet.", 'tilleuls-ortego-papier');
                ?>
            </p>
            <div class="embed-consent__actions">
                <button type="button" class="button button--secondary" data-embed-load hidden>
                    <?php echo $is_calendly ? esc_html__("Afficher l'agenda", 'tilleuls-ortego-papier') : esc_html__('Afficher la carte', 'tilleuls-ortego-papier'); ?>
                </button>
                <?php if ($is_calendly || $address) : ?>
                    <a class="button button--tertiary" href="<?php echo esc_url($direct_url); ?>" target="_blank" rel="noopener">
                        <?php echo $is_calendly ? esc_html__('Réserver sur Calendly', 'tilleuls-ortego-papier') : esc_html__('Itinéraire vers le cabinet', 'tilleuls-ortego-papier'); ?>
                        <?php echo $new_tab; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php if ($is_calendly && $phone) : ?>
                <p class="embed-consent__alt">
                    <?php esc_html_e('Vous préférez téléphoner ?', 'tilleuls-ortego-papier'); ?>
                    <?php echo $phone; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>
                </p>
            <?php endif; ?>
        </div>
        <p class="embed-consent__loading" data-embed-loading hidden>
            <span class="spinner" aria-hidden="true"></span>
            <?php echo $is_calendly ? esc_html__("Chargement de l'agenda…", 'tilleuls-ortego-papier') : esc_html__('Chargement de la carte…', 'tilleuls-ortego-papier'); ?>
        </p>
        <div class="notice notice--erreur" data-embed-error hidden tabindex="-1">
            <p class="notice__title">
                <?php echo $is_calendly ? esc_html__("L'agenda ne s'affiche pas", 'tilleuls-ortego-papier') : esc_html__('La carte ne s\'affiche pas', 'tilleuls-ortego-papier'); ?>
            </p>
            <p>
                <?php if ($is_calendly) : ?>
                    <?php esc_html_e('Vous pouvez réserver directement sur Calendly', 'tilleuls-ortego-papier'); ?>
                    <?php if ($phone) : ?>
                        <?php esc_html_e('ou appeler le cabinet au', 'tilleuls-ortego-papier'); ?> <?php echo $phone; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>
                    <?php endif; ?>.
                <?php else : ?>
                    <?php esc_html_e("Utilisez le lien d'itinéraire ou l'adresse indiquée.", 'tilleuls-ortego-papier'); ?>
                <?php endif; ?>
            </p>
        </div>
        <div class="embed-consent__frame" data-embed-frame hidden></div>
    </div>
    <?php

    return (string) ob_get_clean();
}

/**
 * Only https Calendly pages can be embedded: the attribute is editable by contributors.
 */
function tilleuls_papier_is_calendly_url(string $url): bool
{
    $parts = wp_parse_url($url);
    $host = strtolower((string) ($parts['host'] ?? ''));

    return 'https' === ($parts['scheme'] ?? '') && ('calendly.com' === $host || str_ends_with($host, '.calendly.com'));
}

// Calendly: the plugin prints the inline widget + widget.js between two HTML comments. The pattern
// requires the exact widget markup (the <script> tag cannot come from post content, kses strips it),
// so a comment copied into the block's inner text is left alone.
add_filter('render_block_tilleuls-ortego-blocks/appointment', function (string $content, array $block): string {
    $url = (string) ($block['attrs']['calendly'] ?? '');
    if ('' === $url) {
        return $content;
    }

    $replacement = tilleuls_papier_is_calendly_url($url)
        ? tilleuls_papier_embed_placeholder('calendly', $url)
        : '<p>' . esc_html__('La prise de rendez-vous en ligne est momentanément indisponible. Contactez le cabinet par téléphone ou par e-mail.', 'tilleuls-ortego-papier') . '</p>';

    return (string) preg_replace_callback(
        '#<!-- Début de widget en ligne Calendly -->\s*<div class="calendly-inline-widget"[^>]*></div>\s*'
            . '<script\b[^>]*\bsrc="https://assets\.calendly\.com/assets/external/widget\.js"[^>]*></script>\s*'
            . '<!-- Fin de widget en ligne Calendly -->#',
        static fn (): string => $replacement,
        $content,
        1
    );
}, 10, 2);

// Google Maps iframe printed by tilleuls_ortego_blocks_render_map().
$tilleuls_papier_block_map = static function (string $content): string {
    return (string) preg_replace_callback(
        '#<iframe\b[^>]*\bsrc="https://maps\.google\.com/[^"]*"[^>]*>\s*</iframe>#s',
        static function (array $match): string {
            $tags = new WP_HTML_Tag_Processor($match[0]);
            $tags->next_tag('iframe');

            return tilleuls_papier_embed_placeholder(
                'map',
                html_entity_decode((string) $tags->get_attribute('src')),
                (string) $tags->get_attribute('title')
            );
        },
        $content
    );
};
add_filter('render_block_tilleuls-ortego-blocks/contact-column', $tilleuls_papier_block_map);
add_filter('render_block_tilleuls-ortego-blocks/contact-map', $tilleuls_papier_block_map);

// Page header of inner pages: the breadcrumb sits above the title, in the same band.
add_filter('render_block_tilleuls-ortego-blocks/hero-page', function (string $content): string {
    $trail = tilleuls_papier_breadcrumb_trail();
    if (!$trail) {
        return $content;
    }

    $breadcrumb = tilleuls_papier_breadcrumb_markup($trail);

    return (string) preg_replace_callback('#^\s*<div\b[^>]*>#', static fn (array $m): string => $m[0] . $breadcrumb, $content, 1);
});
