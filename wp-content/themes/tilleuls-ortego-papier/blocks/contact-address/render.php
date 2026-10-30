<?php
/**
 * Firm address in the same card as the plugin's info-box, read from the contact options on every request.
 *
 * @var array $attributes
 */

declare(strict_types=1);

$contact = tilleuls_papier_contact();
$street = implode(' - ', array_filter([$contact['street'], $contact['complement']]));
$city = trim($contact['zip'] . ' ' . $contact['city']);
if (!$street && !$city) {
    return;
}
?>
<section <?php echo get_block_wrapper_attributes(['class' => 'section-contact-details']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped by core. ?>>
    <div class="info-card">
        <div class="info-item">
            <div class="info-title">
                <i aria-hidden="true" class="fa-solid fa-location-dot"></i>
                <h3><?php esc_html_e('Adresse du cabinet', 'tilleuls-ortego-papier'); ?></h3>
            </div>
            <p><?php echo implode('<br>', array_map('esc_html', array_filter([$street, $city]))); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- each line escaped. ?></p>
        </div>
    </div>
</section>
