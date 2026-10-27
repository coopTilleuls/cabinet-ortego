<?php
/**
 * Enregistre les réglages pour les coordonnées du cabinet.
 * Les champs apparaîtront dans Réglages > Général.
 */

declare(strict_types=1);

/**
 * @return array<string, array{label: string, type: string, class: string}>
 */
function tilleuls_contact_fields(): array
{
    return [
        'tilleuls_contact_name' => ['label' => 'Nom complet / Raison sociale', 'type' => 'text', 'class' => 'regular-text'],
        'tilleuls_address_street' => ['label' => 'Numéro et voie', 'type' => 'text', 'class' => 'large-text'],
        'tilleuls_address_complement' => ['label' => 'Complément d\'adresse (étage, etc.)', 'type' => 'text', 'class' => 'regular-text'],
        'tilleuls_address_zip' => ['label' => 'Code Postal', 'type' => 'text', 'class' => 'regular-text'],
        'tilleuls_address_city' => ['label' => 'Ville', 'type' => 'text', 'class' => 'regular-text'],
        'tilleuls_address_country' => ['label' => 'Pays', 'type' => 'text', 'class' => 'regular-text'],
        'tilleuls_contact_phone' => ['label' => 'Numéro de téléphone', 'type' => 'tel', 'class' => 'regular-text'],
        'tilleuls_contact_email' => ['label' => 'Adresse e-mail', 'type' => 'email', 'class' => 'regular-text'],
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
                'sanitize_callback' => $field['type'] === 'email' ? 'sanitize_email' : 'sanitize_text_field',
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
            ['label_for' => $option_name, 'type' => $field['type'], 'class_name' => $field['class']]
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
