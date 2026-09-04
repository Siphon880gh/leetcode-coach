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

/**
 * @param mixed $meta
 */
function render_leetcode_row($meta): void
{
    $n = content_leetcode_number($meta);
    if ($n === null) {
        return;
    }
    echo '<p class="leetcode-no">' . content_leetcode_label_html($n) . '</p>';
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
 * Page-head chrome: Algo Guide ↔ Step-by-step. Renders only when the key is set
 * and the other artifact is on disk. $from is `guide` or `session`.
 *
 * @param array<string, mixed> $meta
 */
function render_companion_link(string $from, array $meta): void
{
    if ($from === 'guide') {
        $slug = companion_slug($meta, 'related_session');
        if ($slug === null || load_content('coaching', $slug) === null) {
            return;
        }
        $href = url('coaching/session.php?id=' . rawurlencode($slug));
        echo '<p class="companion-link"><a href="' . e($href) . '">Step-by-step</a></p>';
        return;
    }

    if ($from !== 'session') {
        return;
    }

    $slug = companion_slug($meta, 'related_guide');
    if ($slug === null) {
        return;
    }
    $item = load_content('guides', $slug);
    if ($item === null || normalize_guide_kind($item['meta']['kind'] ?? null) !== 'algo') {
        return;
    }
    $href = url('guides/view.php?id=' . rawurlencode($slug));
    echo '<p class="companion-link"><a href="' . e($href) . '">Algo Guide</a></p>';
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
                        <p class="pop__title">Browse</p>
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
                                                    <li>
                                                        <a class="taxonomy-topics__item" href="<?= e($href) ?>">
                                                            <span class="taxonomy-topics__name"><?= e($title) ?></span>
                                                        </a>
                                                        <?php if ($lc !== null): ?>
                                                            <span class="taxonomy-topics__lc"><?= content_leetcode_label_html($lc) ?></span>
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
                        class="pop__panel<?= $userTags ? ' pop__panel--filter' : '' ?>"
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
                <p class="empty-state" data-user-tag-empty hidden>No resources with that tag.</p>
                <ul class="content-tiles">
                    <?php foreach ($visible as $item): ?>
                        <?php
                        $meta = $item['meta'];
                        $href = (string) $itemHref($item);
                        $tags = $meta['tags'] ?? [];
                        ?>
                        <li class="content-tile"<?php if ($userTags): ?> data-user-tag-resource="<?= e(user_tag_resource_key($script, (string) $item['slug'])) ?>"<?php endif; ?>>
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
