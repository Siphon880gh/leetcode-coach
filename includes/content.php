<?php
/**
 * Content loaders for guides, games, and step-by-step sessions (content/coaching/).
 * Each artifact lives under content/{type}/{slug}/ with meta.php (and type-specific files).
 */

declare(strict_types=1);

function content_root(): string
{
    return dirname(__DIR__) . '/content';
}

/**
 * Guide list section: cursor (Cursor AI usage) or algo (DSA / system design / LeetCode).
 * Missing or unknown meta.kind defaults to algo.
 */
/** @param mixed $kind */
function normalize_guide_kind($kind): string
{
    return $kind === 'cursor' ? 'cursor' : 'algo';
}

function guide_kind_label(string $kind): string
{
    return normalize_guide_kind($kind) === 'cursor' ? 'Cursor AI Guides' : 'Algo Guides';
}

function guide_list_url(string $kind): string
{
    $kind = normalize_guide_kind($kind);
    return url('guides/index.php?kind=' . rawurlencode($kind));
}

/**
 * @return list<array{slug: string, meta: array<string, mixed>}>
 */
function list_guides(string $kind): array
{
    $kind = normalize_guide_kind($kind);
    $items = [];
    foreach (list_content('guides') as $item) {
        if (normalize_guide_kind($item['meta']['kind'] ?? null) === $kind) {
            $items[] = $item;
        }
    }
    return $items;
}

/**
 * @return list<array{slug: string, meta: array<string, mixed>}>
 */
function list_content(string $type): array
{
    $dir = content_root() . '/' . $type;
    if (!is_dir($dir)) {
        return [];
    }

    $items = [];
    foreach (scandir($dir) ?: [] as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $metaPath = $dir . '/' . $entry . '/meta.php';
        if (!is_file($metaPath)) {
            continue;
        }
        $meta = require $metaPath;
        if (!is_array($meta)) {
            continue;
        }
        $items[] = [
            'slug' => $entry,
            'meta' => $meta,
        ];
    }

    usort($items, static function (array $a, array $b): int {
        return strcmp((string) ($a['meta']['title'] ?? $a['slug']), (string) ($b['meta']['title'] ?? $b['slug']));
    });

    return $items;
}

/**
 * @return array{slug: string, meta: array<string, mixed>, path: string}|null
 */
function load_content(string $type, string $slug): ?array
{
    if ($slug === '' || strpos($slug, '..') !== false || strpos($slug, '/') !== false) {
        return null;
    }

    $path = content_root() . '/' . $type . '/' . $slug;
    $metaPath = $path . '/meta.php';
    if (!is_file($metaPath)) {
        return null;
    }

    $meta = require $metaPath;
    if (!is_array($meta)) {
        return null;
    }

    return [
        'slug' => $slug,
        'meta' => $meta,
        'path' => $path,
    ];
}

/**
 * @return array<string, mixed>|null
 */
function load_coaching_tree(string $slug): ?array
{
    $item = load_content('coaching', $slug);
    if ($item === null) {
        return null;
    }

    $treePath = $item['path'] . '/tree.php';
    if (!is_file($treePath)) {
        return null;
    }

    $tree = require $treePath;
    return is_array($tree) ? $tree : null;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function base_path(): string
{
    static $base = null;
    if ($base !== null) {
        return $base;
    }

    $appRoot = realpath(dirname(__DIR__));
    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath((string) $_SERVER['DOCUMENT_ROOT']) : false;

    if ($appRoot !== false && $docRoot !== false) {
        $appNorm = str_replace('\\', '/', $appRoot);
        $docNorm = str_replace('\\', '/', $docRoot);
        if (strpos($appNorm, $docNorm) === 0) {
            $rel = substr($appNorm, strlen($docNorm));
            $base = rtrim(str_replace('\\', '/', (string) $rel), '/');
            if ($base === '' || $base === '.') {
                $base = '';
            }
            return $base;
        }
    }

    $script = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));
    $dir = dirname($script);
    foreach (['/guides', '/games', '/coaching'] as $suffix) {
        $len = strlen($suffix);
        if ($len > 0 && substr($dir, -$len) === $suffix) {
            $dir = dirname($dir);
            break;
        }
    }
    $base = rtrim($dir, '/');
    if ($base === '' || $base === '.' || $base === '/') {
        $base = '';
    }
    return $base;
}

function url(string $path): string
{
    $path = '/' . ltrim($path, '/');
    return base_path() . $path;
}
