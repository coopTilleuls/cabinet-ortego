<?php
/**
 * Site header: skip links, logotype, main navigation, language switcher and booking call to action.
 * Everything works without JavaScript (disclosures are <details>); assets/js/navigation.js only adds
 * Escape / click-outside closing.
 *
 * @var array $attributes
 */

declare(strict_types=1);

$items = tilleuls_papier_menu_items();
$languages = tilleuls_papier_languages();
$booking_url = tilleuls_papier_booking_url();
$current_language = current(array_filter($languages, static fn (array $lang): bool => $lang['current'])) ?: null;

wp_enqueue_script(
    'tilleuls-papier-navigation',
    get_stylesheet_directory_uri() . '/assets/js/navigation.js',
    [],
    tilleuls_papier_asset_version('/assets/js/navigation.js'),
    ['strategy' => 'defer', 'in_footer' => true]
);

$render_menu = static function (array $items): void {
    ?>
    <ul class="site-nav__list">
        <?php foreach ($items as $item) : ?>
            <li>
                <a class="site-nav__link" href="<?php echo esc_url($item['url']); ?>"<?php echo $item['current'] ? ' aria-current="page"' : ''; ?>>
                    <?php echo esc_html($item['title']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
};

$render_language_list = static function (array $languages): void {
    ?>
    <ul class="lang-switch__list">
        <?php foreach ($languages as $lang) : ?>
            <li>
                <a class="lang-switch__link" href="<?php echo esc_url($lang['url']); ?>"
                   hreflang="<?php echo esc_attr($lang['locale']); ?>" lang="<?php echo esc_attr($lang['locale']); ?>"
                   <?php echo $lang['current'] ? ' aria-current="true"' : ''; ?>>
                    <span><?php echo esc_html($lang['name']); ?></span>
                    <span class="lang-switch__code" aria-hidden="true"><?php echo esc_html(strtoupper($lang['slug'])); ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
};
?>
<div <?php echo get_block_wrapper_attributes(['class' => 'site-header-wrap', 'id' => 'haut']); ?>>
    <nav class="skip-links" aria-label="<?php esc_attr_e("Liens d'évitement", 'tilleuls-ortego-papier'); ?>">
        <ul>
            <li><a class="skip-link" href="#contenu"><?php esc_html_e('Aller au contenu', 'tilleuls-ortego-papier'); ?></a></li>
            <li><a class="skip-link" href="#navigation"><?php esc_html_e('Aller à la navigation', 'tilleuls-ortego-papier'); ?></a></li>
            <li><a class="skip-link" href="#pied-de-page"><?php esc_html_e('Aller au pied de page', 'tilleuls-ortego-papier'); ?></a></li>
        </ul>
    </nav>

    <header class="site-header">
        <div class="site-header__inner">
            <a class="logo" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                <span class="logo__mark" aria-hidden="true"><span>O</span><span class="logo__s">S</span></span>
                <span class="logo__text">
                    <span class="logo__name"><?php esc_html_e('Ortego Sampedro', 'tilleuls-ortego-papier'); ?></span>
                    <span class="logo__role"><?php esc_html_e('Avocate · Barreau de Pau', 'tilleuls-ortego-papier'); ?></span>
                </span>
                <span class="screen-reader-text"><?php esc_html_e('— accueil', 'tilleuls-ortego-papier'); ?></span>
            </a>

            <div class="site-header__tools" id="navigation" tabindex="-1">
                <?php if ($items) : ?>
                    <nav class="site-nav site-nav--desktop" aria-label="<?php esc_attr_e('Navigation principale', 'tilleuls-ortego-papier'); ?>">
                        <?php $render_menu($items); ?>
                    </nav>
                <?php endif; ?>

                <?php if (count($languages) > 1) : ?>
                    <details class="lang-switch disclosure">
                        <summary class="lang-switch__toggle">
                            <?php echo tilleuls_papier_icon('globe'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
                            <span aria-hidden="true"><?php echo esc_html(strtoupper($current_language['slug'] ?? '')); ?></span>
                            <span class="screen-reader-text">
                                <?php
                                /* translators: %s: current language name. */
                                echo esc_html(sprintf(__('Langue : %s. Changer de langue', 'tilleuls-ortego-papier'), $current_language['name'] ?? ''));
                                ?>
                            </span>
                        </summary>
                        <div class="disclosure__panel">
                            <?php $render_language_list($languages); ?>
                        </div>
                    </details>
                <?php endif; ?>

                <?php if ($booking_url) : ?>
                    <a class="button button--primary site-header__cta" href="<?php echo esc_url($booking_url); ?>">
                        <?php esc_html_e('Prendre rendez-vous', 'tilleuls-ortego-papier'); ?>
                    </a>
                <?php endif; ?>

                <details class="site-nav--mobile disclosure">
                    <summary class="button button--secondary site-nav__toggle">
                        <?php echo tilleuls_papier_icon('menu'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
                        <?php esc_html_e('Menu', 'tilleuls-ortego-papier'); ?>
                    </summary>
                    <div class="disclosure__panel site-nav__panel">
                        <nav class="site-nav" aria-label="<?php esc_attr_e('Navigation principale', 'tilleuls-ortego-papier'); ?>">
                            <?php $render_menu($items); ?>
                        </nav>
                        <?php if ($booking_url) : ?>
                            <a class="button button--primary" href="<?php echo esc_url($booking_url); ?>">
                                <?php esc_html_e('Prendre rendez-vous', 'tilleuls-ortego-papier'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (count($languages) > 1) : ?>
                            <div class="lang-switch lang-switch--inline">
                                <p class="eyebrow" id="langues-mobile"><?php esc_html_e('Langue', 'tilleuls-ortego-papier'); ?></p>
                                <nav aria-labelledby="langues-mobile"><?php $render_language_list($languages); ?></nav>
                            </div>
                        <?php endif; ?>
                    </div>
                </details>
            </div>
        </div>
    </header>
</div>
