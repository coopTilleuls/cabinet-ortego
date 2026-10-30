<?php
/**
 * H1 of the fallback template (index.html): posts page, search results, archives.
 * core/query-title only covers archives and searches, which left the posts page without a heading.
 *
 * @var array $attributes
 */

declare(strict_types=1);

echo '<h1 ' . get_block_wrapper_attributes() . '>' . esc_html(tilleuls_papier_listing_title()) . '</h1>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wrapper escaped by core.
