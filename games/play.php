<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/layout.php';

$slug = isset($_GET['id']) ? (string) $_GET['id'] : '';
$item = load_content('games', $slug);

if ($item === null) {
    http_response_code(404);
    layout_start(['title' => 'Game not found', 'active' => 'games']);
    echo '<p class="empty-state">Game not found.</p>';
    echo '<a class="back-link" href="' . e(url('games/index.php')) . '">← All mini games</a>';
    layout_end();
    exit;
}

$meta = $item['meta'];
$entry = (string) ($meta['entry'] ?? 'index.html');
$gameUrl = url('content/games/' . rawurlencode($slug) . '/' . ltrim($entry, '/'));

layout_start([
    'title' => (string) ($meta['title'] ?? $slug),
    'description' => (string) ($meta['summary'] ?? ''),
    'active' => 'games',
]);
?>

<a class="back-link" href="<?= e(url('games/index.php')) ?>">← All mini games</a>

<div class="page-head">
    <p class="content-card__meta"><?= e((string) ($meta['topic'] ?? 'Mini game')) ?></p>
    <h1><?= e((string) ($meta['title'] ?? $slug)) ?></h1>
    <p><?= e((string) ($meta['summary'] ?? '')) ?></p>
</div>

<div class="game-frame-wrap">
    <iframe
        class="game-frame"
        title="<?= e((string) ($meta['title'] ?? 'Mini game')) ?>"
        src="<?= e($gameUrl) ?>"
        loading="lazy"
    ></iframe>
</div>

<?php
layout_end();
