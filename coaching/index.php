<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/layout.php';

$sessions = list_content('coaching');
$cat = isset($_GET['cat']) ? trim((string) $_GET['cat']) : '';
$sub = isset($_GET['sub']) ? trim((string) $_GET['sub']) : '';

layout_start([
    'title' => 'Step-by-step',
    'description' => 'Deterministic wizards that branch on your choices — step back when you go wrong.',
    'active' => 'coaching',
]);
?>

<div class="page-head">
    <h1>Step-by-step</h1>
    <p>
        Deterministic wizards: each choice leads to a fixed next message. Reach a wrong ending and you are told
        when to step back. Use Step back to return to the previous decision (or the rewind point named on that leaf).
    </p>
</div>

<?php
render_content_browse($sessions, [
    'script' => 'coaching/index.php',
    'query' => [],
    'cat' => $cat,
    'sub' => $sub,
    'empty' => 'No step-by-step sessions yet. Prompt Cursor with <code>.agents/skills/harness</code> to create one under <code>content/coaching/</code>.',
    'item_href' => static function (array $item): string {
        return url('coaching/session.php?id=' . rawurlencode($item['slug']));
    },
]);

layout_end();
