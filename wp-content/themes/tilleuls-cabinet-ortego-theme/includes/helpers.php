<?php

declare(strict_types=1);

/**
 * Split the site title into its first word and the rest, used by the header to style them differently.
 *
 * @return array{first: string, last: string}
 */
function tilleuls_split_title(string $title): array
{
    $words = explode(' ', $title);

    return [
        'first' => (string) array_shift($words),
        'last' => implode(' ', $words),
    ];
}
