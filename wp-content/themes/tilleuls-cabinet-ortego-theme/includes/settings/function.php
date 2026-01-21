<?php
/**
 * Enregistre les réglages pour les coordonnées du cabinet.
 * Les champs apparaîtront dans Réglages > Général.
 */

declare(strict_types=1);

function tilleuls_register_contact_settings()
{
    $fields = [
        'tilleuls_contact_name' => 'Nom complet / Raison sociale',
        'tilleuls_address_street' => 'Numéro et voie',
        'tilleuls_address_complement' => 'Complément d\'adresse (étage, etc.)',
        'tilleuls_address_zip' => 'Code Postal',
        'tilleuls_address_city' => 'Ville',
        'tilleuls_address_country' => 'Pays',
        'tilleuls_contact_phone' => 'Numéro de téléphone',
        'tilleuls_contact_email' => 'Adresse e-mail'
    ];

    foreach ($fields as $option_name => $label) {
        register_setting(
            'general',
            $option_name,
            [
                'type' => 'string',
                'sanitize_callback' => ($option_name === 'tilleuls_contact_email' ? 'sanitize_email' : 'sanitize_text_field'),
                'default' => '',
                'show_in_rest' => true,
            ]
        );
        add_settings_field(
            $option_name,
            $label,
            'tilleuls_render_generic_field',
            'general',
            'default',
            array('label_for' => $option_name)
        );
    }
}

add_action('admin_init', 'tilleuls_register_contact_settings');

/**
 * @param array $args Les arguments passés par add_settings_field
 */
function tilleuls_render_generic_field($args)
{
    $option_name = $args['label_for'];

    $value = get_option($option_name);
    $type = (strpos($option_name, 'email') !== false) ? 'email' : 'text';

    $class = 'regular-text';
    if (strpos($option_name, 'street') !== false) {
        $class = 'large-text';
    }

    ?>
    <input
            type="<?php
            echo esc_attr($type); ?>"
            name="<?php
            echo esc_attr($option_name); ?>"
            id="<?php
            echo esc_attr($option_name); ?>"
            value="<?php
            echo esc_attr($value); ?>"
            class="<?php
            echo esc_attr($class); ?>"
    >
    <?php
}
