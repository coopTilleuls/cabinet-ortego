<?php
/**
 * Enregistre les réglages pour les coordonnées du cabinet.
 * Les champs apparaîtront dans Réglages > Général.
 */

declare(strict_types=1);

/**
 * @return array<string, array{label: string, type: string, class_name: string}>
 */
function tilleuls_contact_fields(): array
{
    return [
        'tilleuls_contact_name' => ['label' => __('Nom complet / Raison sociale', 'tilleuls-cabinet-ortego-theme'), 'type' => 'text', 'class_name' => 'regular-text'],
        'tilleuls_address_street' => ['label' => __('Numéro et voie', 'tilleuls-cabinet-ortego-theme'), 'type' => 'text', 'class_name' => 'large-text'],
        'tilleuls_address_complement' => ['label' => __('Complément d\'adresse (étage, etc.)', 'tilleuls-cabinet-ortego-theme'), 'type' => 'text', 'class_name' => 'regular-text'],
        'tilleuls_address_zip' => ['label' => __('Code Postal', 'tilleuls-cabinet-ortego-theme'), 'type' => 'text', 'class_name' => 'regular-text'],
        'tilleuls_address_city' => ['label' => __('Ville', 'tilleuls-cabinet-ortego-theme'), 'type' => 'text', 'class_name' => 'regular-text'],
        'tilleuls_address_country' => ['label' => __('Pays', 'tilleuls-cabinet-ortego-theme'), 'type' => 'text', 'class_name' => 'regular-text'],
        'tilleuls_contact_phone' => ['label' => __('Numéro de téléphone', 'tilleuls-cabinet-ortego-theme'), 'type' => 'tel', 'class_name' => 'regular-text'],
        'tilleuls_contact_email' => ['label' => __('Adresse e-mail', 'tilleuls-cabinet-ortego-theme'), 'type' => 'email', 'class_name' => 'regular-text'],
    ];
}

/**
 * Settings are registered on `init` so they are exposed to the REST API (block editor) and not only in wp-admin.
 */
function tilleuls_register_contact_settings(): void
{
    foreach (tilleuls_contact_fields() as $option_name => $field) {
        register_setting(
            'general',
            $option_name,
            [
                'type' => 'string',
                'sanitize_callback' => 'email' === $field['type'] ? 'sanitize_email' : 'sanitize_text_field',
                'default' => '',
                'show_in_rest' => true,
            ]
        );
    }
}

add_action('init', 'tilleuls_register_contact_settings');

function tilleuls_add_contact_settings_fields(): void
{
    foreach (tilleuls_contact_fields() as $option_name => $field) {
        add_settings_field(
            $option_name,
            $field['label'],
            'tilleuls_render_generic_field',
            'general',
            'default',
            ['label_for' => $option_name, 'type' => $field['type'], 'class_name' => $field['class_name']]
        );
    }
}

add_action('admin_init', 'tilleuls_add_contact_settings_fields');

/**
 * @param array $args Les arguments passés par add_settings_field
 */
function tilleuls_render_generic_field($args)
{
    $option_name = $args['label_for'];
    $value = get_option($option_name);

    ?>
    <input
            type="<?php
            echo esc_attr($args['type']); ?>"
            name="<?php
            echo esc_attr($option_name); ?>"
            id="<?php
            echo esc_attr($option_name); ?>"
            value="<?php
            echo esc_attr($value); ?>"
            class="<?php
            echo esc_attr($args['class_name']); ?>"
    >
    <?php
}
