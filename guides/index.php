<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/layout.php';

$kindParam = isset($_GET['kind']) ? (string) $_GET['kind'] : '';
if ($kindParam !== 'cursor' && $kindParam !== 'algo') {
    header('Location: ' . guide_list_url('algo'), true, 302);
    exit;
}

$kind = normalize_guide_kind($kindParam);
$guides = list_guides($kind);
$label = guide_kind_label($kind);
$active = $kind === 'cursor' ? 'guides-cursor' : 'guides-algo';
$cat = isset($_GET['cat']) ? trim((string) $_GET['cat']) : '';
$sub = isset($_GET['sub']) ? trim((string) $_GET['sub']) : '';

$blurb = $kind === 'cursor'
    ? 'How to use Cursor with this app\'s harness — fill prompt builders, copy into your IDE, and scaffold new games or step-by-step sessions.'
    : 'Lessons on algorithms, system design, and LeetCode patterns. Complexity notes, walkthroughs, and prompts to deepen practice in this IDE.';

layout_start([
    'title' => $label,
    'description' => $blurb,
    'active' => $active,
]);
?>

<div class="page-head">
    <h1><?= e($label) ?></h1>
    <p><?= e($blurb) ?></p>
</div>

<?php
render_content_browse($guides, [
    'script' => 'guides/index.php',
    'query' => ['kind' => $kind],
    'cat' => $cat,
    'sub' => $sub,
    'user_tags' => $kind === 'algo',
    'empty' => 'No guides in this section yet. Prompt Cursor with <code>.agents/skills/harness</code> to create one under <code>content/guides/</code> with <code>kind => \'' . e($kind) . '\'</code>.',
    'item_href' => static function (array $item): string {
        return url('guides/view.php?id=' . rawurlencode($item['slug']));
    },
]);

layout_end();
