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

function taxonomy_equals(string $a, string $b): bool
{
    return strcasecmp($a, $b) === 0;
}

/**
 * @param mixed $meta
 * @return array{category: string, subcategory: string}
 */
function content_taxonomy($meta): array
{
    $category = '';
    $subcategory = '';
    $topic = '';

    if (is_array($meta)) {
        $category = trim((string) ($meta['category'] ?? ''));
        $subcategory = trim((string) ($meta['subcategory'] ?? ''));
        $topic = trim((string) ($meta['topic'] ?? ''));
    }

    if (($category === '' || $subcategory === '') && $topic !== '') {
        $parts = preg_split('/\s*[·\/|>]\s*/u', $topic) ?: [];
        $parts = array_values(array_filter(array_map('trim', $parts), static function ($part) {
            return $part !== '';
        }));
        if ($category === '' && isset($parts[0])) {
            $category = $parts[0];
        }
        if ($subcategory === '' && isset($parts[1])) {
            $subcategory = $parts[1];
        }
    }

    if ($category === '') {
        $category = 'Uncategorized';
    }
    if ($subcategory === '') {
        $subcategory = 'General';
    }

    return [
        'category' => $category,
        'subcategory' => $subcategory,
    ];
}

/**
 * Numbered LeetCode problem id from meta, if present.
 *
 * @param mixed $meta
 */
function content_leetcode_number($meta): ?int
{
    if (!is_array($meta) || !array_key_exists('leetcode', $meta)) {
        return null;
    }

    $raw = $meta['leetcode'];
    if (is_int($raw)) {
        return $raw > 0 ? $raw : null;
    }
    if (is_string($raw) && preg_match('/^[1-9][0-9]*$/', trim($raw)) === 1) {
        return (int) trim($raw);
    }

    return null;
}

function content_leetcode_url(int $n): ?string
{
    static $map = null;
    if ($map === null) {
        $path = dirname(__DIR__) . '/context-leetcode-urls/data-cleaned.json';
        $raw = is_file($path) ? file_get_contents($path) : false;
        $decoded = is_string($raw) ? json_decode($raw, true) : null;
        $map = is_array($decoded) ? $decoded : [];
    }

    $url = $map[$n] ?? $map[(string) $n] ?? null;
    if (!is_string($url) || strncmp($url, 'https://leetcode.com/', 21) !== 0) {
        return null;
    }

    return $url;
}

function content_leetcode_label_html(int $n): string
{
    $label = 'LeetCode ' . e((string) $n);
    $url = content_leetcode_url($n);
    if ($url === null) {
        return $label;
    }

    return '<a class="leetcode-link" href="' . e($url) . '" target="_blank" rel="noopener noreferrer">' . $label . '</a>';
}

function content_leetcode_company_level_rank(string $level): int
{
    if (preg_match('/^([1-5])-/', $level, $m) === 1) {
        return (int) $m[1];
    }

    return 9;
}

/**
 * @return array<string, mixed>
 */
function content_leetcode_companies_levels_data(): array
{
    static $data = null;
    if ($data !== null) {
        return $data;
    }

    $data = [];
    $path = dirname(__DIR__) . '/context-leetcode-companies/levels.json';
    if (!is_file($path)) {
        return $data;
    }

    $raw = file_get_contents($path);
    $decoded = is_string($raw) ? json_decode($raw, true) : null;
    $data = is_array($decoded) ? $decoded : [];

    return $data;
}

/**
 * Compensation bands from context-leetcode-companies/levels.json.
 *
 * @return list<array{id: string, name: string, rank: int}>
 */
function content_leetcode_company_levels(): array
{
    static $levels = null;
    if ($levels !== null) {
        return $levels;
    }

    $levels = [];
    $rows = content_leetcode_companies_levels_data()['levels'] ?? [];
    if (!is_array($rows)) {
        return $levels;
    }

    foreach ($rows as $row) {
        if (!is_array($row)) {
            continue;
        }
        $id = trim((string) ($row['id'] ?? ''));
        $name = trim((string) ($row['name'] ?? ''));
        if ($id === '' || $name === '') {
            continue;
        }
        $levels[] = [
            'id' => $id,
            'name' => $name,
            'rank' => (int) ($row['rank'] ?? content_leetcode_company_level_rank($id)),
        ];
    }

    return $levels;
}

/**
 * Senior SWE median total compensation from levels.json, keyed by company slug.
 *
 * @return array<string, array{seniorTcUsd: int, seniorTitle: string}>
 */
function content_leetcode_company_compensation(): array
{
    static $pay = null;
    if ($pay !== null) {
        return $pay;
    }

    $pay = [];
    $rows = content_leetcode_companies_levels_data()['companies'] ?? [];
    if (!is_array($rows)) {
        return $pay;
    }

    foreach ($rows as $row) {
        if (!is_array($row)) {
            continue;
        }
        $slug = strtolower(trim((string) ($row['slug'] ?? '')));
        if ($slug === '' || isset($pay[$slug])) {
            continue;
        }
        $usd = $row['seniorTcUsd'] ?? null;
        if (!is_numeric($usd)) {
            continue;
        }
        $amount = (int) $usd;
        if ($amount < 1) {
            continue;
        }
        $pay[$slug] = [
            'seniorTcUsd' => $amount,
            'seniorTitle' => trim((string) ($row['seniorTitle'] ?? '')),
        ];
    }

    return $pay;
}

function content_format_usd_k(int $usd): string
{
    if ($usd < 1000) {
        return '$' . number_format($usd);
    }

    return '$' . number_format((int) round($usd / 1000)) . 'k';
}

/**
 * @return list<array{slug: string, name: string, level: string, problems: list<int>}>
 */
function content_leetcode_company_catalog(): array
{
    static $catalog = null;
    if ($catalog !== null) {
        return $catalog;
    }

    $catalog = [];
    $dir = dirname(__DIR__) . '/context-leetcode-companies';
    $indexPath = $dir . '/index.json';
    if (!is_file($indexPath)) {
        return $catalog;
    }

    $raw = file_get_contents($indexPath);
    $decoded = is_string($raw) ? json_decode($raw, true) : null;
    $entries = is_array($decoded) && isset($decoded['companies']) && is_array($decoded['companies'])
        ? $decoded['companies']
        : [];

    $seenSlug = [];
    $companies = [];
    foreach ($entries as $entry) {
        if (!is_array($entry)) {
            continue;
        }
        $slug = strtolower(trim((string) ($entry['slug'] ?? '')));
        if ($slug === '' || isset($seenSlug[$slug])) {
            continue;
        }
        $rel = str_replace('\\', '/', trim((string) ($entry['file'] ?? '')));
        if ($rel === '' || strpos($rel, '..') !== false || strncmp($rel, '/', 1) === 0) {
            continue;
        }
        $path = $dir . '/' . $rel;
        if (!is_file($path)) {
            continue;
        }
        $body = file_get_contents($path);
        $data = is_string($body) ? json_decode($body, true) : null;
        if (!is_array($data) || !isset($data['problems']) || !is_array($data['problems'])) {
            continue;
        }
        $name = trim((string) ($data['name'] ?? $entry['name'] ?? $slug));
        if ($name === '') {
            $name = $slug;
        }
        $seenSlug[$slug] = true;
        $problems = [];
        $seenNum = [];
        foreach ($data['problems'] as $num) {
            if (is_int($num)) {
                $problem = $num;
            } elseif (is_string($num) && preg_match('/^[1-9][0-9]*$/', trim($num)) === 1) {
                $problem = (int) trim($num);
            } else {
                continue;
            }
            if ($problem < 1 || isset($seenNum[$problem])) {
                continue;
            }
            $seenNum[$problem] = true;
            $problems[] = $problem;
        }
        $companies[] = [
            'slug' => $slug,
            'name' => $name,
            'level' => trim((string) ($entry['level'] ?? '')),
            'problems' => $problems,
        ];
    }

    usort($companies, static function (array $a, array $b): int {
        $rank = content_leetcode_company_level_rank($a['level']) <=> content_leetcode_company_level_rank($b['level']);
        if ($rank !== 0) {
            return $rank;
        }

        return strcasecmp($a['name'], $b['name']);
    });

    $catalog = $companies;

    return $catalog;
}

/**
 * Company names whose interview lists include this LeetCode id (highest band first).
 *
 * @return list<string>
 */
function content_leetcode_company_names(int $n): array
{
    $map = content_leetcode_company_names_by_problem();

    return $map[$n] ?? [];
}

/**
 * Company slugs whose interview lists include this LeetCode id (highest band first).
 *
 * @return list<string>
 */
function content_leetcode_company_slugs(int $n): array
{
    $map = content_leetcode_company_slugs_by_problem();

    return $map[$n] ?? [];
}

/**
 * @return array<int, list<string>>
 */
function content_leetcode_company_names_by_problem(): array
{
    static $map = null;
    if ($map !== null) {
        return $map;
    }

    $map = [];
    foreach (content_leetcode_company_catalog() as $company) {
        foreach ($company['problems'] as $problem) {
            $map[$problem][] = $company['name'];
        }
    }

    return $map;
}

/**
 * @return array<int, list<string>>
 */
function content_leetcode_company_slugs_by_problem(): array
{
    static $map = null;
    if ($map !== null) {
        return $map;
    }

    $map = [];
    foreach (content_leetcode_company_catalog() as $company) {
        foreach ($company['problems'] as $problem) {
            $map[$problem][] = $company['slug'];
        }
    }

    return $map;
}

/**
 * @return list<array{id: string, name: string, companies: list<array{slug: string, name: string, seniorTcUsd: ?int, seniorTitle: string}>}>
 */
function content_leetcode_companies_grouped(): array
{
    $grouped = [];
    foreach (content_leetcode_company_levels() as $level) {
        $grouped[$level['id']] = [
            'id' => $level['id'],
            'name' => $level['name'],
            'companies' => [],
        ];
    }

    $pay = content_leetcode_company_compensation();
    foreach (content_leetcode_company_catalog() as $company) {
        $id = $company['level'] !== '' ? $company['level'] : 'other';
        if (!isset($grouped[$id])) {
            $grouped[$id] = [
                'id' => $id,
                'name' => $id === 'other' ? 'Other' : $id,
                'companies' => [],
            ];
        }
        $comp = $pay[$company['slug']] ?? null;
        $grouped[$id]['companies'][] = [
            'slug' => $company['slug'],
            'name' => $company['name'],
            'seniorTcUsd' => $comp['seniorTcUsd'] ?? null,
            'seniorTitle' => $comp['seniorTitle'] ?? '',
        ];
    }

    $out = [];
    foreach ($grouped as $group) {
        if ($group['companies'] !== []) {
            $out[] = $group;
        }
    }

    return $out;
}

function content_browse_has_leetcode(array $items): bool
{
    foreach ($items as $item) {
        if (content_leetcode_number($item['meta'] ?? []) !== null) {
            return true;
        }
    }

    return false;
}

function content_leetcode_companies_html(int $n): string
{
    $names = content_leetcode_company_names($n);
    if ($names === []) {
        return '';
    }

    $chips = '';
    foreach ($names as $name) {
        $chips .= '<span class="leetcode-co" aria-hidden="true">' . e($name) . '</span>';
    }

    return '<span class="leetcode-cos" aria-label="' . e('Asked at ' . implode(', ', $names)) . '">' . $chips . '</span>';
}

/**
 * YouTube results URL for a numbered LeetCode problem.
 * Query is "Leet Code {n} {title}" with punctuation skipped and spaces as +.
 */
function content_youtube_search_url(int $n, string $title): string
{
    $phrase = 'Leet Code ' . $n . ' ' . $title;
    $cleaned = preg_replace('/[^A-Za-z0-9 ]+/', ' ', $phrase);
    $cleaned = is_string($cleaned) ? preg_replace('/\s+/', ' ', $cleaned) : '';
    $cleaned = trim(is_string($cleaned) ? $cleaned : '');

    return 'https://www.youtube.com/results?' . http_build_query(['search_query' => $cleaned]);
}

function content_youtube_link_html(int $n, string $title, bool $labeled = false): string
{
    $url = content_youtube_search_url($n, $title);
    $label = 'YouTube: Leet Code ' . $n;
    $class = $labeled ? 'youtube-search youtube-search--labeled' : 'youtube-search';
    $inner = '<svg class="youtube-search__icon" width="12" height="12" viewBox="0 0 24 24" aria-hidden="true" focusable="false">'
        . '<path fill="currentColor" fill-rule="evenodd" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>'
        . '</svg>';
    if ($labeled) {
        $inner .= '<span class="youtube-search__label">' . e('YouTube') . '</span>';
    }
    $attrs = ' class="' . $class . '" href="' . e($url) . '" target="_blank" rel="noopener noreferrer" title="' . e($label) . '"';
    if (!$labeled) {
        $attrs .= ' aria-label="' . e($label) . '"';
    }

    return '<a' . $attrs . '>' . $inner . '</a>';
}

/**
 * LeetCode number link plus YouTube search icon for numbered problems.
 *
 * @param mixed $meta
 */
function content_leetcode_chrome_html($meta): string
{
    $n = content_leetcode_number($meta);
    if ($n === null) {
        return '';
    }
    $title = is_array($meta) ? (string) ($meta['title'] ?? '') : '';

    return '<span class="leetcode-no__line">'
        . '<span class="leetcode-no__id">'
        . content_leetcode_label_html($n)
        . '</span>'
        . content_youtube_link_html($n, $title)
        . '</span>'
        . content_leetcode_companies_html($n);
}

/**
 * @param mixed $meta
 */
function render_leetcode_row($meta): void
{
    $html = content_leetcode_chrome_html($meta);
    if ($html === '') {
        return;
    }
    echo '<p class="leetcode-no">' . $html . '</p>';
}

/**
 * @param mixed $meta
 */
function companion_slug($meta, string $key): ?string
{
    if (!is_array($meta) || !array_key_exists($key, $meta)) {
        return null;
    }
    $slug = trim((string) $meta[$key]);
    if ($slug === '' || strpos($slug, '..') !== false || strpos($slug, '/') !== false) {
        return null;
    }

    return $slug;
}

/**
 * @param array{slug: string, meta: array<string, mixed>} $item
 */
function companion_item_is_usable(string $type, array $item): bool
{
    if ($type !== 'guides') {
        return true;
    }

    return normalize_guide_kind($item['meta']['kind'] ?? null) === 'algo';
}

/**
 * Existing companion slug: related_* key, same folder slug, or matching leetcode id.
 *
 * @param array<string, mixed> $meta
 */
function companion_existing_slug(string $type, array $meta, string $ownSlug, string $relatedKey): ?string
{
    $related = companion_slug($meta, $relatedKey);
    if ($related !== null) {
        $item = load_content($type, $related);
        if ($item !== null && companion_item_is_usable($type, $item)) {
            return $related;
        }
    }

    $ownSlug = trim($ownSlug);
    if ($ownSlug !== '') {
        $item = load_content($type, $ownSlug);
        if ($item !== null && companion_item_is_usable($type, $item)) {
            return $ownSlug;
        }
    }

    $n = content_leetcode_number($meta);
    if ($n === null) {
        return null;
    }

    foreach (list_content($type) as $item) {
        if (!companion_item_is_usable($type, $item)) {
            continue;
        }
        if (content_leetcode_number($item['meta'] ?? []) === $n) {
            return $item['slug'];
        }
    }

    return null;
}

/**
 * Step-by-step slug already on disk for this Algo Guide, if any.
 *
 * @param array<string, mixed> $meta
 */
function guide_existing_session_slug(array $meta, string $guideSlug): ?string
{
    return companion_existing_slug('coaching', $meta, $guideSlug, 'related_session');
}

/**
 * Mini game slug already on disk for this guide or session, if any.
 *
 * @param array<string, mixed> $meta
 */
function companion_existing_game_slug(array $meta, string $ownSlug): ?string
{
    return companion_existing_slug('games', $meta, $ownSlug, 'related_game');
}

/**
 * Page-head chrome between Algo Guide, Step-by-step, and Mini game.
 * $from is `guide`, `session`, or `game`.
 *
 * @param array<string, mixed> $meta
 */
function render_companion_link(string $from, array $meta, string $ownSlug = ''): void
{
    $links = [];

    if ($from === 'guide') {
        $session = guide_existing_session_slug($meta, $ownSlug);
        if ($session !== null) {
            $links[] = [
                'href' => url('coaching/session.php?id=' . rawurlencode($session)),
                'label' => 'Step-by-step',
            ];
        }
        $game = companion_existing_game_slug($meta, $ownSlug);
        if ($game !== null) {
            $links[] = [
                'href' => url('games/play.php?id=' . rawurlencode($game)),
                'label' => 'Mini game',
            ];
        }
    } elseif ($from === 'session') {
        $guide = companion_existing_slug('guides', $meta, $ownSlug, 'related_guide');
        if ($guide !== null) {
            $links[] = [
                'href' => url('guides/view.php?id=' . rawurlencode($guide)),
                'label' => 'Algo Guide',
            ];
        }
        $game = companion_existing_game_slug($meta, $ownSlug);
        if ($game !== null) {
            $links[] = [
                'href' => url('games/play.php?id=' . rawurlencode($game)),
                'label' => 'Mini game',
            ];
        }
    } elseif ($from === 'game') {
        $guide = companion_existing_slug('guides', $meta, $ownSlug, 'related_guide');
        if ($guide !== null) {
            $links[] = [
                'href' => url('guides/view.php?id=' . rawurlencode($guide)),
                'label' => 'Algo Guide',
            ];
        }
        $session = companion_existing_slug('coaching', $meta, $ownSlug, 'related_session');
        if ($session !== null) {
            $links[] = [
                'href' => url('coaching/session.php?id=' . rawurlencode($session)),
                'label' => 'Step-by-step',
            ];
        }
    }

    if ($links === []) {
        return;
    }

    echo '<p class="companion-link">';
    foreach ($links as $i => $link) {
        if ($i > 0) {
            echo '<span class="companion-link__sep" aria-hidden="true"> · </span>';
        }
        echo '<a href="' . e($link['href']) . '">' . e($link['label']) . '</a>';
    }
    echo '</p>';
}

/**
 * Insert or update a string meta.php key. Returns true when the file changed.
 */
function content_meta_ensure_string_key(string $path, string $key, string $value): bool
{
    if (!is_file($path) || preg_match('/^[a-z][a-z0-9_]*$/', $key) !== 1) {
        return false;
    }
    if (preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value) !== 1) {
        return false;
    }

    $raw = file_get_contents($path);
    if (!is_string($raw) || $raw === '') {
        return false;
    }

    $keyPat = preg_quote($key, '/');
    if (preg_match("/'" . $keyPat . "'\\s*=>\\s*'([^']*)'/", $raw, $m) === 1) {
        if ($m[1] === $value) {
            return false;
        }
        $updated = preg_replace(
            "/'" . $keyPat . "'\\s*=>\\s*'[^']*'/",
            "'" . $key . "' => '" . $value . "'",
            $raw,
            1
        );
        if (!is_string($updated) || $updated === $raw) {
            return false;
        }

        return file_put_contents($path, $updated) !== false;
    }

    if (preg_match('/^(.*?)(\n\];\s*)$/s', $raw, $m) !== 1) {
        return false;
    }
    $before = rtrim($m[1], " \t");
    if ($before === '' || substr($before, -1) === '[') {
        return false;
    }
    if (substr($before, -1) !== ',') {
        $before .= ',';
    }
    $updated = $before . "\n    '" . $key . "' => '" . $value . "',\n];\n";

    return file_put_contents($path, $updated) !== false;
}

/**
 * @param list<array{slug: string, meta: array<string, mixed>}> $items
 * @return array<string, array<string, list<array{slug: string, meta: array<string, mixed>}>>>
 */
function content_taxonomy_tree(array $items): array
{
    $tree = [];
    foreach ($items as $item) {
        $tax = content_taxonomy($item['meta'] ?? []);
        $tree[$tax['category']][$tax['subcategory']][] = $item;
    }

    uksort($tree, 'strnatcasecmp');
    foreach ($tree as &$subs) {
        uksort($subs, 'strnatcasecmp');
        foreach ($subs as &$group) {
            usort($group, static function (array $a, array $b): int {
                return strnatcasecmp(
                    (string) ($a['meta']['title'] ?? $a['slug']),
                    (string) ($b['meta']['title'] ?? $b['slug'])
                );
            });
        }
        unset($group);
    }
    unset($subs);

    return $tree;
}

/**
 * @param list<array{slug: string, meta: array<string, mixed>}> $items
 * @return list<array{slug: string, meta: array<string, mixed>}>
 */
function filter_content_taxonomy(array $items, string $cat, string $sub): array
{
    if ($cat === '') {
        return $items;
    }

    $out = [];
    foreach ($items as $item) {
        $tax = content_taxonomy($item['meta'] ?? []);
        if (!taxonomy_equals($tax['category'], $cat)) {
            continue;
        }
        if ($sub !== '' && !taxonomy_equals($tax['subcategory'], $sub)) {
            continue;
        }
        $out[] = $item;
    }

    return $out;
}

/**
 * Lowercased haystack for Browse search (title, slug, taxonomy, summary, tags, LeetCode id, company names).
 *
 * @param array{slug?: string, meta?: mixed} $item
 */
function content_browse_query_haystack(array $item): string
{
    $meta = is_array($item['meta'] ?? null) ? $item['meta'] : [];
    $tax = content_taxonomy($meta);
    $parts = [
        (string) ($meta['title'] ?? ''),
        (string) ($item['slug'] ?? ''),
        $tax['category'],
        $tax['subcategory'],
        (string) ($meta['summary'] ?? ''),
    ];
    $lc = content_leetcode_number($meta);
    if ($lc !== null) {
        $parts[] = (string) $lc;
        $parts[] = 'leetcode ' . $lc;
        foreach (content_leetcode_company_names($lc) as $companyName) {
            $parts[] = $companyName;
        }
    }
    if (isset($meta['tags']) && is_array($meta['tags'])) {
        foreach ($meta['tags'] as $tag) {
            $parts[] = (string) $tag;
        }
    }
    $hay = preg_replace('/\s+/u', ' ', implode(' ', $parts));
    $hay = is_string($hay) ? $hay : '';
    if (function_exists('mb_strtolower')) {
        return mb_strtolower($hay, 'UTF-8');
    }

    return strtolower($hay);
}

function user_tag_section(string $script): string
{
    if (strpos($script, 'games/') === 0) {
        return 'games';
    }
    if (strpos($script, 'coaching/') === 0) {
        return 'coaching';
    }

    return 'guides';
}

function user_tag_resource_key(string $script, string $slug): string
{
    return user_tag_section($script) . ':' . $slug;
}

/**
 * @param list<array{id: string, name: string, companies: list<array{slug: string, name: string, seniorTcUsd?: ?int, seniorTitle?: string}>}> $groups
 */
function render_content_filter_companies(array $groups): void
{
    if ($groups === []) {
        return;
    }
    ?>
    <div class="filter-tags filter-companies" data-filter-companies>
        <button
            type="button"
            class="filter-tags__btn"
            data-filter-companies-btn
            aria-expanded="false"
            aria-haspopup="true"
            aria-controls="resource-filter-companies"
        >
            <span class="filter-tags__caret" aria-hidden="true">◂</span>
            <span class="filter-tags__icon" aria-hidden="true">🏢</span>
            Companies
        </button>
        <div
            id="resource-filter-companies"
            class="filter-tags__panel"
            data-filter-companies-panel
            hidden
            role="dialog"
            aria-label="Companies"
        >
            <ul class="pop__list">
                <?php foreach ($groups as $group): ?>
                    <?php $levelId = 'resource-filter-companies-' . $group['id']; ?>
                    <li class="filter-company-level" data-filter-company-level="<?= e($group['id']) ?>">
                        <button
                            type="button"
                            class="filter-tags__btn"
                            data-filter-company-level-btn
                            aria-expanded="false"
                            aria-haspopup="true"
                            aria-controls="<?= e($levelId) ?>"
                        >
                            <span class="filter-tags__caret" aria-hidden="true">◂</span>
                            <?= e($group['name']) ?>
                            <span class="resource-n" data-filter-company-level-n hidden></span>
                        </button>
                        <div
                            id="<?= e($levelId) ?>"
                            class="filter-tags__panel filter-company-level__panel"
                            data-filter-company-level-panel
                            hidden
                            role="dialog"
                            aria-label="<?= e($group['name'] . ' companies') ?>"
                        >
                            <div class="filter-company-level__tools">
                                <button type="button" data-filter-company-select-all>Select all</button>
                                <button type="button" data-filter-company-clear>Clear</button>
                            </div>
                            <ul class="pop__list">
                                <?php foreach ($group['companies'] as $company): ?>
                                    <?php
                                    $payUsd = isset($company['seniorTcUsd']) ? (int) $company['seniorTcUsd'] : 0;
                                    $payLabel = $payUsd > 0 ? content_format_usd_k($payUsd) : '';
                                    $payHint = '';
                                    if ($payLabel !== '') {
                                        $title = trim((string) ($company['seniorTitle'] ?? ''));
                                        $payHint = ($title !== '' ? $title . ' · ' : '')
                                            . 'Senior engineer median TC $' . number_format($payUsd);
                                    }
                                    ?>
                                    <li>
                                        <button
                                            type="button"
                                            class="pop__opt"
                                            data-filter-company="<?= e($company['slug']) ?>"
                                            aria-pressed="false"
                                            <?php if ($payHint !== ''): ?>
                                            title="<?= e($payHint) ?>"
                                            aria-label="<?= e($company['name'] . ', ' . $payLabel) ?>"
                                            <?php endif; ?>
                                        ><?= e($company['name']) ?><?php if ($payLabel !== ''): ?> <span class="resource-n"><?= e($payLabel) ?></span><?php endif; ?></button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php
}

function render_user_tag_editor(): void
{
    ?>
    <div class="user-tags" data-user-tags>
        <div class="user-tags__applied" data-user-tags-applied></div>
        <div class="user-tag-pop" data-user-tag-pop>
            <button
                type="button"
                class="user-tag-add"
                data-user-tag-open
                aria-expanded="false"
                aria-haspopup="true"
            >+ Tag</button>
            <div class="user-tag-picker" data-user-tag-picker hidden></div>
        </div>
    </div>
    <?php
}

function render_user_tag_page(string $script, string $slug): void
{
    ?>
    <div class="user-tags-page" data-user-tags-root data-user-tag-section="<?= e(user_tag_section($script)) ?>">
        <div data-user-tag-resource="<?= e(user_tag_resource_key($script, $slug)) ?>">
            <?php render_user_tag_editor(); ?>
        </div>
    </div>
    <?php
}

/**
 * Page-head actions: + Tag, LeetCode, YouTube, then companion links.
 * $from is `guide`, `session`, or `game`.
 *
 * @param array<string, mixed> $meta
 */
function render_resource_head_chrome(string $from, array $meta, string $ownSlug, string $tagScript): void
{
    echo '<div class="page-head__links">';
    render_user_tag_page($tagScript, $ownSlug);

    $n = content_leetcode_number($meta);
    if ($n !== null) {
        echo '<p class="leetcode-no">'
            . '<span class="leetcode-no__line">'
            . '<span class="leetcode-no__id">'
            . content_leetcode_label_html($n)
            . '</span>'
            . '<span class="leetcode-no__sep" aria-hidden="true"></span>'
            . content_youtube_link_html($n, (string) ($meta['title'] ?? ''), true)
            . '</span>'
            . content_leetcode_companies_html($n)
            . '</p>';
    }

    render_companion_link($from, $meta, $ownSlug);
    echo '</div>';
}

/**
 * @param array<string, string> $params
 */
function content_list_href(string $script, array $params): string
{
    $filtered = [];
    foreach ($params as $key => $value) {
        if ($value === '') {
            continue;
        }
        $filtered[$key] = $value;
    }
    $query = http_build_query($filtered);

    return url($script . ($query !== '' ? '?' . $query : ''));
}

/**
 * @param array<string, string> $baseQuery
 */
function render_content_crumb(array $meta, string $script, array $baseQuery): void
{
    $tax = content_taxonomy($meta);
    $catHref = content_list_href($script, array_merge($baseQuery, [
        'cat' => $tax['category'],
        'sub' => '',
    ]));
    $subHref = content_list_href($script, array_merge($baseQuery, [
        'cat' => $tax['category'],
        'sub' => $tax['subcategory'],
    ]));
    ?>
    <nav class="crumb" aria-label="Category">
        <a class="crumb__link" href="<?= e($catHref) ?>"><?= e($tax['category']) ?></a>
        <span class="crumb__sep" aria-hidden="true">/</span>
        <a class="crumb__link" href="<?= e($subHref) ?>"><?= e($tax['subcategory']) ?></a>
    </nav>
    <?php
}

/**
 * Browse panel (category → subcategory → topics accordion) plus resource tiles with breadcrumbs.
 *
 * @param list<array{slug: string, meta: array<string, mixed>}> $items
 * @param array{
 *   script: string,
 *   query?: array<string, string>,
 *   cat?: string,
 *   sub?: string,
 *   empty: string,
 *   item_href: callable,
 *   user_tags?: bool
 * } $opts
 */
function render_content_browse(array $items, array $opts): void
{
    $script = (string) ($opts['script'] ?? '');
    $baseQuery = $opts['query'] ?? [];
    $cat = trim((string) ($opts['cat'] ?? ''));
    $sub = trim((string) ($opts['sub'] ?? ''));
    $empty = (string) ($opts['empty'] ?? 'Nothing here yet.');
    $userTags = !empty($opts['user_tags']);
    $tagSection = user_tag_section($script);
    $companyGroups = content_browse_has_leetcode($items) ? content_leetcode_companies_grouped() : [];
    $hasFlyouts = $userTags || $companyGroups !== [];
    /** @var callable $itemHref */
    $itemHref = $opts['item_href'];

    if ($items === []) {
        echo '<p class="empty-state">' . $empty . '</p>';
        return;
    }

    $tree = content_taxonomy_tree($items);
    $visible = filter_content_taxonomy($items, $cat, $sub);
    $allHref = content_list_href($script, $baseQuery);
    $heading = 'All resources';
    if ($cat !== '') {
        $heading = $sub !== '' ? $cat . ' / ' . $sub : $cat;
    }
    $visibleCount = count($visible);
    ?>
    <div class="browse"<?php if ($userTags): ?> data-user-tags-root data-user-tag-section="<?= e($tagSection) ?>"<?php endif; ?>>
        <div class="browse__toolbar">
            <h2 class="browse__heading"><?= e($heading) ?> <span class="resource-n">(<?= $visibleCount ?>)</span></h2>
            <div class="browse__actions">
                <div class="pop" data-pop>
                    <button
                        type="button"
                        class="pop__btn"
                        data-pop-btn
                        aria-expanded="false"
                        aria-controls="resource-browse"
                        aria-haspopup="dialog"
                    >Browse</button>
                    <div
                        id="resource-browse"
                        class="pop__panel pop__panel--browse"
                        data-pop-panel
                        hidden
                        role="dialog"
                        aria-label="Browse"
                    >
                        <div class="pop__head">
                            <p class="pop__title">Browse</p>
                            <button
                                type="button"
                                class="browse-sort"
                                data-browse-sort="usual"
                                aria-label="Sort, usual order"
                            >
                                <svg class="browse-sort__icon" width="14" height="12" viewBox="0 0 14 12" aria-hidden="true" focusable="false">
                                    <rect x="0" y="0.75" width="14" height="1.7" fill="currentColor"/>
                                    <rect x="0" y="5.15" width="10" height="1.7" fill="currentColor"/>
                                    <rect x="0" y="9.55" width="6" height="1.7" fill="currentColor"/>
                                </svg>
                                <span data-browse-sort-label>Sort</span>
                            </button>
                        </div>
                        <div class="browse-search" data-browse-search>
                            <div class="browse-search__field">
                                <input
                                    id="resource-browse-q"
                                    class="browse-search__input"
                                    type="text"
                                    data-browse-search-input
                                    placeholder="Search"
                                    autocomplete="off"
                                    autocorrect="off"
                                    spellcheck="false"
                                    role="combobox"
                                    aria-label="Search"
                                    aria-autocomplete="list"
                                    aria-expanded="false"
                                    aria-controls="resource-browse-suggest"
                                >
                                <button
                                    type="button"
                                    class="browse-search__clear"
                                    data-browse-search-clear
                                    hidden
                                    aria-label="Clear search"
                                >×</button>
                            </div>
                            <ul
                                id="resource-browse-suggest"
                                class="browse-search__suggest"
                                data-browse-suggest
                                role="listbox"
                                hidden
                            ></ul>
                        </div>
                        <nav class="taxonomy" aria-label="Categories">
                            <?php foreach ($tree as $category => $subs): ?>
                                <?php
                                $catCount = 0;
                                foreach ($subs as $group) {
                                    $catCount += count($group);
                                }
                                $catCurrent = $cat !== '' && taxonomy_equals($cat, $category);
                                $catClass = 'taxonomy-acc' . ($catCurrent ? ' is-current' : '');
                                ?>
                                <details class="<?= e($catClass) ?>" <?= $catCurrent ? 'open' : '' ?>>
                                    <summary class="taxonomy-acc__summary">
                                        <span class="taxonomy-acc__label"><?= e($category) ?></span>
                                        <span class="taxonomy-acc__n"><?= (int) $catCount ?></span>
                                    </summary>
                                    <?php foreach ($subs as $subcategory => $group): ?>
                                        <?php
                                        $subCurrent = $catCurrent && $sub !== '' && taxonomy_equals($sub, $subcategory);
                                        $subClass = 'taxonomy-acc taxonomy-acc--nested' . ($subCurrent ? ' is-current' : '');
                                        ?>
                                        <details class="<?= e($subClass) ?>" <?= $subCurrent ? 'open' : '' ?>>
                                            <summary class="taxonomy-acc__summary">
                                                <span class="taxonomy-acc__label"><?= e($subcategory) ?></span>
                                                <span class="taxonomy-acc__n"><?= count($group) ?></span>
                                            </summary>
                                            <ul class="taxonomy-topics">
                                                <?php foreach ($group as $topicItem): ?>
                                                    <?php
                                                    $href = (string) $itemHref($topicItem);
                                                    $title = (string) ($topicItem['meta']['title'] ?? $topicItem['slug']);
                                                    $lc = content_leetcode_number($topicItem['meta'] ?? []);
                                                    ?>
                                                    <li<?php if ($lc !== null): ?> data-leetcode="<?= (int) $lc ?>"<?php endif; ?>>
                                                        <a class="taxonomy-topics__item" href="<?= e($href) ?>">
                                                            <span class="taxonomy-topics__name"><?= e($title) ?></span>
                                                        </a>
                                                        <?php if ($lc !== null): ?>
                                                            <span class="taxonomy-topics__lc"><?= content_leetcode_chrome_html($topicItem['meta'] ?? []) ?></span>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </details>
                                    <?php endforeach; ?>
                                </details>
                            <?php endforeach; ?>
                        </nav>
                    </div>
                </div>
                <div class="filter-ctrl">
                <div class="pop" data-pop>
                    <button
                        type="button"
                        class="pop__btn<?= $cat !== '' ? ' is-active has-filter' : '' ?>"
                        data-pop-btn
                        aria-expanded="false"
                        aria-controls="resource-filter"
                        aria-haspopup="dialog"
                        aria-label="<?= $cat !== '' ? 'Filter, ' . e($heading) : 'Filter' ?>"
                    >Filter</button>
                    <div
                        id="resource-filter"
                        class="pop__panel<?= $hasFlyouts ? ' pop__panel--filter' : '' ?>"
                        data-pop-panel
                        hidden
                        role="dialog"
                        aria-label="Filter"
                    >
                        <?php if ($userTags): ?>
                            <div class="filter-tags" data-filter-tags>
                                <button
                                    type="button"
                                    class="filter-tags__btn"
                                    data-filter-tags-btn
                                    aria-expanded="false"
                                    aria-haspopup="true"
                                    aria-controls="resource-filter-tags"
                                >
                                    <span class="filter-tags__caret" aria-hidden="true">◂</span>
                                    <span class="filter-tags__icon" aria-hidden="true">🏷</span>
                                    Tags
                                </button>
                                <div
                                    id="resource-filter-tags"
                                    class="filter-tags__panel"
                                    data-filter-tags-panel
                                    hidden
                                    role="dialog"
                                    aria-label="Tags"
                                >
                                    <ul class="pop__list pop__list--tags" data-user-tag-filters></ul>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($companyGroups !== []): ?>
                            <?php render_content_filter_companies($companyGroups); ?>
                        <?php endif; ?>
                        <p class="pop__title"><?= $userTags ? 'Topics' : 'Filter' ?></p>
                        <ul class="pop__list pop__list--topics">
                            <li>
                                <a
                                    class="pop__opt<?= $cat === '' ? ' is-current' : '' ?>"
                                    href="<?= e($allHref) ?>"
                                >All resources <span class="resource-n">(<?= count($items) ?>)</span></a>
                            </li>
                            <?php foreach ($tree as $category => $subs): ?>
                                <?php
                                $catCount = 0;
                                foreach ($subs as $group) {
                                    $catCount += count($group);
                                }
                                $catHref = content_list_href($script, array_merge($baseQuery, [
                                    'cat' => $category,
                                    'sub' => '',
                                ]));
                                $catOptCurrent = $cat !== '' && taxonomy_equals($cat, $category) && $sub === '';
                                ?>
                                <li>
                                    <a
                                        class="pop__opt pop__opt--cat<?= $catOptCurrent ? ' is-current' : '' ?>"
                                        href="<?= e($catHref) ?>"
                                    ><?= e($category) ?> <span class="resource-n">(<?= (int) $catCount ?>)</span></a>
                                    <ul>
                                        <?php foreach ($subs as $subcategory => $group): ?>
                                            <?php
                                            $subHref = content_list_href($script, array_merge($baseQuery, [
                                                'cat' => $category,
                                                'sub' => $subcategory,
                                            ]));
                                            $subOptCurrent = $cat !== '' && taxonomy_equals($cat, $category) && taxonomy_equals($sub, $subcategory);
                                            ?>
                                            <li>
                                                <a
                                                    class="pop__opt pop__opt--sub<?= $subOptCurrent ? ' is-current' : '' ?>"
                                                    href="<?= e($subHref) ?>"
                                                ><?= e($subcategory) ?> <span class="resource-n">(<?= count($group) ?>)</span></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <a
                    class="filter-clear"
                    href="<?= e($allHref) ?>"
                    data-filter-clear
                    aria-label="Clear filters"
                    <?= $cat !== '' ? '' : 'hidden' ?>
                >×</a>
                </div>
            </div>
        </div>
            <?php if ($visible === []): ?>
                <p class="empty-state">No resources in this category. <a href="<?= e($allHref) ?>">Show all</a></p>
            <?php else: ?>
                <p class="empty-state" data-user-tag-empty hidden>No resources match those filters.</p>
                <p class="empty-state" data-browse-empty hidden>No resources match that search.</p>
                <ul class="content-tiles">
                    <?php foreach ($visible as $item): ?>
                        <?php
                        $meta = $item['meta'];
                        $href = (string) $itemHref($item);
                        $tags = $meta['tags'] ?? [];
                        $lc = content_leetcode_number($meta);
                        $companySlugs = $lc !== null ? content_leetcode_company_slugs($lc) : [];
                        ?>
                        <li class="content-tile" data-browse-q="<?= e(content_browse_query_haystack($item)) ?>"<?php if ($lc !== null): ?> data-leetcode="<?= (int) $lc ?>"<?php endif; ?><?php if ($companySlugs !== []): ?> data-companies="<?= e(implode(' ', $companySlugs)) ?>"<?php endif; ?><?php if ($userTags): ?> data-user-tag-resource="<?= e(user_tag_resource_key($script, (string) $item['slug'])) ?>"<?php endif; ?>>
                            <?php render_content_crumb($meta, $script, $baseQuery); ?>
                            <div class="content-tile__body">
                                <a class="content-tile__goto" href="<?= e($href) ?>">
                                    <h3 class="content-tile__title"><?= e((string) ($meta['title'] ?? $item['slug'])) ?></h3>
                                </a>
                                <?php render_leetcode_row($meta); ?>
                                <a class="content-tile__goto" href="<?= e($href) ?>">
                                    <p class="content-tile__desc"><?= e((string) ($meta['summary'] ?? '')) ?></p>
                                    <?php if (is_array($tags) && $tags !== []): ?>
                                        <div class="tags">
                                            <?php foreach ($tags as $tag): ?>
                                                <span class="tag"><?= e((string) $tag) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <?php if ($userTags): ?>
                                <?php render_user_tag_editor(); ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
    </div>
    <?php
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
