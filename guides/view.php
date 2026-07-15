<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/layout.php';

$slug = isset($_GET['id']) ? (string) $_GET['id'] : '';
$item = load_content('guides', $slug);

if ($item === null) {
    http_response_code(404);
    layout_start(['title' => 'Guide not found', 'active' => 'guides']);
    echo '<p class="empty-state">Guide not found.</p>';
    echo '<a class="back-link" href="' . e(url('guides/index.php')) . '">← All guides</a>';
    layout_end();
    exit;
}

$meta = $item['meta'];
$bodyPath = $item['path'] . '/body.php';

layout_start([
    'title' => (string) ($meta['title'] ?? $slug),
    'description' => (string) ($meta['summary'] ?? ''),
    'active' => 'guides',
]);
?>

<a class="back-link" href="<?= e(url('guides/index.php')) ?>">← All guides</a>

<div class="page-head">
    <p class="content-card__meta"><?= e((string) ($meta['topic'] ?? 'Guide')) ?></p>
    <h1><?= e((string) ($meta['title'] ?? $slug)) ?></h1>
    <p><?= e((string) ($meta['summary'] ?? '')) ?></p>
</div>

<article class="guide-body">
<?php
if (is_file($bodyPath)) {
    require $bodyPath;
} else {
    echo '<p class="empty-state">This guide has no body.php yet.</p>';
}
?>
</article>

<?php
layout_end();
