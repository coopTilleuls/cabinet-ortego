<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$attributes = $attributes ?? [];
$infoItems = $attributes['infoItems'] ?? [];

$blockWrapper = get_block_wrapper_attributes([
	'class' => 'section-contact-details',
]);


$ICONS = [
	'tag' => [
		'label' => 'Tarif (Etiquette)',
		'class' => 'fa-solid fa-tag',
	],
	'creditCard' => [
		'label' => 'Paiement (Carte)',
		'class' => 'fa-regular fa-credit-card',
	],
	'location' => [
		'label' => 'Lieu (Map)',
		'class' => 'fa-solid fa-location-dot',
	],
	'folder' => [
		'label' => 'Dossier',
		'class' => 'fa-solid fa-folder-open',
	],
	'phone' => [
		'label' => 'Téléphone',
		'class' => 'fa-solid fa-phone',
	],
	'envelope' => [
		'label' => 'Email',
		'class' => 'fa-solid fa-envelope',
	],
	'clock' => [
		'label' => 'Horaires',
		'class' => 'fa-solid fa-clock',
	],
	'info' => [
		'label' => 'Info (Cercle)',
		'class' => 'fa-solid fa-info-circle',
	],
	'balance' => [
		'label' => 'Balance',
		'class' => 'fa-solid fa-scale-balanced',
	],
	'shield' => [
		'label' => 'Bouclier',
		'class' => 'fa-solid fa-shield-halved',
	],
];
?>
<section <?php
echo $blockWrapper; ?>>
	<div class="info-card">
		<?php
		foreach ($infoItems as $item): ?>
			<div class="info-item">
				<div class="info-title">
					<i class="<?php
					echo $ICONS[$item['icon']]['class'] ?>"></i>
					<h4><?php
						echo wp_kses_post($item['title']); ?></h4>
				</div>
				<?php
				if ($item['highlight']) : ?>
					<p class="highlight"><?php
						echo wp_kses_post($item['highlight']); ?></p>
				<?php
				endif; ?>

				<?php
				if ($item['content']) : ?>
					<p class="content"><?php
						echo wp_kses_post($item['content']); ?></p>
				<?php
				endif; ?>
			</div>
		<?php
		endforeach; ?>
	</div>
</section>
