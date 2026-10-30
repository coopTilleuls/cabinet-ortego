<?php
/**
 * Breadcrumb: Accueil › ancestors › current page. Hidden on the front page.
 *
 * @var array $attributes
 */

declare(strict_types=1);

$trail = tilleuls_papier_breadcrumb_trail();
if (!$trail) {
    return;
}

echo tilleuls_papier_breadcrumb_markup($trail, get_block_wrapper_attributes(['class' => 'breadcrumb-nav'])); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in the helper.
