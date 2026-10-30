<?php
/**
 * Site footer: consent banner (in the flow, never modal), logotype, site map, contact details
 * from Réglages > Général, legal links and back-to-top link.
 *
 * @var array $attributes
 */

declare(strict_types=1);

$items = tilleuls_papier_menu_items();
$contact = tilleuls_papier_contact();
$legal = tilleuls_papier_legal_links();
$address_lines = array_filter([$contact['street'], $contact['complement'], trim($contact['zip'] . ' ' . $contact['city'])]);
?>
<div <?php echo get_block_wrapper_attributes(['class' => 'site-footer-wrap']); ?>>
    <?php require __DIR__ . '/consent.php'; ?>

    <footer class="site-footer" id="pied-de-page" tabindex="-1">
        <div class="site-footer__inner">
            <div class="site-footer__brand">
                <a class="logo logo--nuit" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <span class="logo__mark" aria-hidden="true"><span>O</span><span class="logo__s">S</span></span>
                    <span class="logo__text">
                        <span class="logo__name"><?php esc_html_e('Ortego Sampedro', 'tilleuls-ortego-papier'); ?></span>
                        <span class="logo__role"><?php esc_html_e('Avocate · Barreau de Pau', 'tilleuls-ortego-papier'); ?></span>
                    </span>
                    <span class="screen-reader-text"><?php esc_html_e('— accueil', 'tilleuls-ortego-papier'); ?></span>
                </a>
                <p><?php esc_html_e('Avocate au Barreau de Pau. Défense pénale et droits des étrangers.', 'tilleuls-ortego-papier'); ?></p>
            </div>

            <?php if ($items) : ?>
                <nav class="site-footer__col" aria-labelledby="pied-le-site">
                    <h2 class="eyebrow" id="pied-le-site"><?php esc_html_e('Le site', 'tilleuls-ortego-papier'); ?></h2>
                    <ul>
                        <?php foreach ($items as $item) : ?>
                            <li><a href="<?php echo esc_url($item['url']); ?>"<?php echo $item['current'] ? ' aria-current="page"' : ''; ?>><?php echo esc_html($item['title']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            <?php endif; ?>

            <?php if ($address_lines || $contact['phone'] || $contact['email']) : ?>
                <div class="site-footer__col">
                    <h2 class="eyebrow"><?php esc_html_e('Coordonnées', 'tilleuls-ortego-papier'); ?></h2>
                    <ul class="contact-list">
                        <?php if ($address_lines) : ?>
                            <li>
                                <?php echo tilleuls_papier_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
                                <address><?php echo implode('<br>', array_map('esc_html', $address_lines)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- each line escaped. ?></address>
                            </li>
                        <?php endif; ?>
                        <?php if ($contact['phone']) : ?>
                            <li>
                                <?php echo tilleuls_papier_icon('phone'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
                                <a href="<?php echo esc_attr(tilleuls_papier_tel_href($contact['phone'])); ?>">
                                    <span class="screen-reader-text"><?php esc_html_e('Appeler le', 'tilleuls-ortego-papier'); ?></span>
                                    <?php echo esc_html($contact['phone']); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($contact['email']) : ?>
                            <li>
                                <?php echo tilleuls_papier_icon('mail'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
                                <a href="<?php echo esc_attr('mailto:' . antispambot($contact['email'])); ?>">
                                    <span class="screen-reader-text"><?php esc_html_e('Écrire à', 'tilleuls-ortego-papier'); ?></span>
                                    <?php echo esc_html(antispambot($contact['email'])); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <nav class="site-footer__col" aria-labelledby="pied-informations">
                <h2 class="eyebrow" id="pied-informations"><?php esc_html_e('Informations', 'tilleuls-ortego-papier'); ?></h2>
                <ul>
                    <?php foreach ($legal as $link) : ?>
                        <li><a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['title']); ?></a></li>
                    <?php endforeach; ?>
                    <li>
                        <a href="#consentement" class="js-consent-open"><?php esc_html_e('Gestion des cookies', 'tilleuls-ortego-papier'); ?></a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="site-footer__bottom">
            <p>
                <?php
                /* translators: %s: current year. */
                echo esc_html(sprintf(__('© %s Cabinet Ortego Sampedro. Tous droits réservés.', 'tilleuls-ortego-papier'), wp_date('Y')));
                ?>
            </p>
            <a href="#haut" class="site-footer__top">
                <?php echo tilleuls_papier_icon('arrow-up'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
                <?php esc_html_e('Haut de page', 'tilleuls-ortego-papier'); ?>
            </a>
        </div>
    </footer>
</div>
