<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/layout.php';
require_once dirname(__DIR__) . '/includes/guide_md.php';

$slug = isset($_GET['id']) ? (string) $_GET['id'] : '';
$item = load_content('guides', $slug);

if ($item === null) {
    http_response_code(404);
    layout_start(['title' => 'Guide not found', 'active' => 'guides-algo']);
    echo '<p class="empty-state">Guide not found.</p>';
    echo '<a class="back-link" href="' . e(guide_list_url('algo')) . '">← Algo Guides</a>';
    layout_end();
    exit;
}

$meta = $item['meta'];
$kind = normalize_guide_kind($meta['kind'] ?? null);
$sectionLabel = guide_kind_label($kind);
$active = $kind === 'cursor' ? 'guides-cursor' : 'guides-algo';
$mdPath = $item['path'] . '/body.md';
$phpPath = $item['path'] . '/body.php';

layout_start([
    'title' => (string) ($meta['title'] ?? $slug),
    'description' => (string) ($meta['summary'] ?? ''),
    'active' => $active,
]);
?>

<a class="back-link" href="<?= e(guide_list_url($kind)) ?>">← <?= e($sectionLabel) ?></a>

<div class="page-head">
    <p class="content-card__meta"><?= e((string) ($meta['topic'] ?? 'Guide')) ?></p>
    <h1><?= e((string) ($meta['title'] ?? $slug)) ?></h1>
    <p><?= e((string) ($meta['summary'] ?? '')) ?></p>
</div>

<article class="guide-body">
<?php
if (is_file($mdPath)) {
    $markdown = file_get_contents($mdPath);
    if ($markdown === false) {
        echo '<p class="empty-state">Could not read body.md.</p>';
    } else {
        echo render_guide_markdown($markdown);
    }
} elseif (is_file($phpPath)) {
    require $phpPath;
} else {
    echo '<p class="empty-state">This guide has no body.md (or body.php) yet.</p>';
}
?>
</article>

<?php
layout_end();
