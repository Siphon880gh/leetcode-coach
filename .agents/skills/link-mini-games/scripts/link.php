#!/usr/bin/env php
<?php
/**
 * Fill related_guide / related_session / related_game for mini games that
 * are missing a link to an existing Algo Guide and/or Step-by-step.
 */
declare(strict_types=1);

$root = dirname(__DIR__, 4);
chdir($root);
require $root . '/includes/content.php';

/**
 * @param array<string, mixed> $meta
 */
function link_mini_games_related_is_valid(array $meta, string $key, string $type): bool
{
    $slug = companion_slug($meta, $key);
    if ($slug === null) {
        return false;
    }
    $item = load_content($type, $slug);

    return $item !== null && companion_item_is_usable($type, $item);
}

/**
 * @param array<string, mixed> $meta
 */
function link_mini_games_should_set_related_game(array $meta, string $gameSlug): bool
{
    $existing = companion_slug($meta, 'related_game');
    if ($existing === null || $existing === $gameSlug) {
        return true;
    }

    return load_content('games', $existing) === null;
}

/**
 * @return array{path: string, meta: array<string, mixed>}|null
 */
function link_mini_games_meta_file(string $type, string $slug): ?array
{
    $item = load_content($type, $slug);
    if ($item === null || !companion_item_is_usable($type, $item)) {
        return null;
    }
    $path = $item['path'] . '/meta.php';
    if (!is_file($path)) {
        return null;
    }

    return ['path' => $path, 'meta' => $item['meta']];
}

$linked = [];
$unchanged = [];
$unmatched = [];

foreach (list_content('games') as $game) {
    $gameSlug = $game['slug'];
    $loaded = load_content('games', $gameSlug);
    if ($loaded === null) {
        continue;
    }
    $meta = $loaded['meta'];
    $gamePath = $loaded['path'] . '/meta.php';
    if (!is_file($gamePath)) {
        continue;
    }

    $guideSlug = companion_existing_slug('guides', $meta, $gameSlug, 'related_guide');
    $sessionSlug = companion_existing_slug('coaching', $meta, $gameSlug, 'related_session');
    $hasGuide = link_mini_games_related_is_valid($meta, 'related_guide', 'guides');
    $hasSession = link_mini_games_related_is_valid($meta, 'related_session', 'coaching');

    $changes = [];

    if ($guideSlug !== null) {
        $guideFile = link_mini_games_meta_file('guides', $guideSlug);
        if ($guideFile !== null) {
            if (content_meta_ensure_string_key($gamePath, 'related_guide', $guideSlug)) {
                $changes[] = 'related_guide=' . $guideSlug;
            }
            if (link_mini_games_should_set_related_game($guideFile['meta'], $gameSlug)
                && content_meta_ensure_string_key($guideFile['path'], 'related_game', $gameSlug)
            ) {
                $changes[] = 'guide.related_game=' . $gameSlug;
            }
        }
    }

    if ($sessionSlug !== null) {
        $sessionFile = link_mini_games_meta_file('coaching', $sessionSlug);
        if ($sessionFile !== null) {
            if (content_meta_ensure_string_key($gamePath, 'related_session', $sessionSlug)) {
                $changes[] = 'related_session=' . $sessionSlug;
            }
            if (link_mini_games_should_set_related_game($sessionFile['meta'], $gameSlug)
                && content_meta_ensure_string_key($sessionFile['path'], 'related_game', $gameSlug)
            ) {
                $changes[] = 'session.related_game=' . $gameSlug;
            }
        }
    }

    $row = [
        'slug' => $gameSlug,
        'guide' => $guideSlug,
        'session' => $sessionSlug,
    ];

    if ($changes !== []) {
        $row['wrote'] = $changes;
        $linked[] = $row;
        continue;
    }

    $complete = $hasGuide && $hasSession;
    if ($complete) {
        $unchanged[] = $row;
        continue;
    }

    $unmatched[] = $row;
}

echo json_encode([
    'linked' => $linked,
    'unchanged' => $unchanged,
    'unmatched' => $unmatched,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
