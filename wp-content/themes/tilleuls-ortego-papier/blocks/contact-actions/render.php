<?php
/**
 * "Appeler" / "Nous écrire" buttons, read from the contact options on every request so a change in
 * Réglages > Général shows up everywhere. Light styles: meant for the red call band or a nuit section.
 *
 * @var array $attributes
 */

declare(strict_types=1);

$contact = tilleuls_papier_contact();
if (!$contact['phone'] && !$contact['email']) {
    return;
}
?>
<div <?php echo get_block_wrapper_attributes(['class' => 'wp-block-buttons is-layout-flex']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped by core. ?>>
    <?php if ($contact['phone']) : ?>
        <div class="wp-block-button is-style-clair">
            <a class="wp-block-button__link wp-element-button" href="<?php echo esc_attr(tilleuls_papier_tel_href($contact['phone'])); ?>">
                <?php
                /* translators: %s: phone number. */
                printf(esc_html__('Appeler le %s', 'tilleuls-ortego-papier'), esc_html($contact['phone']));
                ?>
            </a>
        </div>
    <?php endif; ?>
    <?php if ($contact['email']) : ?>
        <div class="wp-block-button is-style-contour-clair">
            <a class="wp-block-button__link wp-element-button" href="<?php echo esc_attr('mailto:' . $contact['email']); ?>">
                <?php esc_html_e('Nous écrire', 'tilleuls-ortego-papier'); ?><span class="screen-reader-text"> <?php esc_html_e('(ouvre votre messagerie)', 'tilleuls-ortego-papier'); ?></span>
            </a>
        </div>
    <?php endif; ?>
</div>
