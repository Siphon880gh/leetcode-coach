<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/layout.php';

$slug = isset($_GET['id']) ? (string) $_GET['id'] : '';
$item = load_content('coaching', $slug);
$tree = $item !== null ? load_coaching_tree($slug) : null;

if ($item === null || $tree === null) {
    http_response_code(404);
    layout_start(['title' => 'Session not found', 'active' => 'coaching']);
    echo '<p class="empty-state">Coaching session not found.</p>';
    echo '<a class="back-link" href="' . e(url('coaching/index.php')) . '">← All coaching</a>';
    layout_end();
    exit;
}

$meta = $item['meta'];
$nodes = $tree['nodes'] ?? [];
$startId = (string) ($tree['start'] ?? 'start');

$nodeId = isset($_GET['node']) ? (string) $_GET['node'] : $startId;
if ($nodeId === '' || !isset($nodes[$nodeId]) || !is_array($nodes[$nodeId])) {
    $nodeId = $startId;
}

$history = [];
if (isset($_GET['history']) && is_string($_GET['history']) && $_GET['history'] !== '') {
    $decoded = json_decode($_GET['history'], true);
    if (is_array($decoded)) {
        $history = array_values(array_filter($decoded, 'is_string'));
    }
} elseif (isset($_POST['history']) && is_string($_POST['history']) && $_POST['history'] !== '') {
    $decoded = json_decode($_POST['history'], true);
    if (is_array($decoded)) {
        $history = array_values(array_filter($decoded, 'is_string'));
    }
}

// POST choice: append current to history, go to next
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['choice_next'])) {
    $next = (string) $_POST['choice_next'];
    $from = isset($_POST['from_node']) ? (string) $_POST['from_node'] : $nodeId;
    if ($from !== '') {
        $history[] = $from;
    }
    $qs = http_build_query([
        'id' => $slug,
        'node' => $next,
        'history' => json_encode($history),
    ]);
    header('Location: ' . url('coaching/session.php?' . $qs));
    exit;
}

$node = $nodes[$nodeId];
$outcome = (string) ($node['outcome'] ?? 'continue');
$message = (string) ($node['message'] ?? '');
$choices = $node['choices'] ?? [];
$rewindTo = isset($node['rewind_to']) ? (string) $node['rewind_to'] : null;
$historyJson = json_encode($history);

$stepBackHref = null;
if ($history !== [] || $rewindTo) {
    $stack = $history;
    $target = null;
    if ($rewindTo) {
        $idx = array_search($rewindTo, $stack, true);
        if ($idx !== false) {
            $target = $rewindTo;
            $stack = array_slice($stack, 0, (int) $idx);
        } else {
            $target = $rewindTo;
            $stack = [];
        }
    } elseif ($stack !== []) {
        $target = array_pop($stack);
    }
    if ($target !== null) {
        $stepBackHref = url('coaching/session.php?' . http_build_query([
            'id' => $slug,
            'node' => $target,
            'history' => json_encode(array_values($stack)),
        ]));
    }
}

$messageClass = 'coaching-message';
if ($outcome === 'wrong') {
    $messageClass .= ' is-wrong';
} elseif ($outcome === 'success') {
    $messageClass .= ' is-success';
}

layout_start([
    'title' => (string) ($meta['title'] ?? $slug),
    'description' => (string) ($meta['summary'] ?? ''),
    'active' => 'coaching',
]);
?>

<a class="back-link" href="<?= e(url('coaching/index.php')) ?>">← All coaching</a>

<div class="page-head">
    <p class="content-card__meta"><?= e((string) ($meta['topic'] ?? 'Coaching')) ?></p>
    <h1><?= e((string) ($meta['title'] ?? $slug)) ?></h1>
</div>

<div
    id="coaching-session"
    class="coaching-panel"
    data-node="<?= e($nodeId) ?>"
    data-history-key="coaching-<?= e($slug) ?>"
>
    <p class="coaching-path">Step: <code><?= e($nodeId) ?></code><?php if ($history !== []): ?> · path depth <?= count($history) ?><?php endif; ?></p>

    <div class="<?= e($messageClass) ?>">
        <?= nl2br(e($message)) ?>
        <?php if ($outcome === 'wrong' && $rewindTo): ?>
            <p style="margin-top: 1rem; margin-bottom: 0;"><strong>Step back to when:</strong> <code><?= e($rewindTo) ?></code></p>
        <?php endif; ?>
    </div>

    <?php if (is_array($choices) && $choices !== [] && $outcome === 'continue'): ?>
        <div class="coaching-choices">
            <?php foreach ($choices as $i => $choice): ?>
                <?php
                if (!is_array($choice)) {
                    continue;
                }
                $label = (string) ($choice['label'] ?? 'Continue');
                $next = (string) ($choice['next'] ?? '');
                if ($next === '' || !isset($nodes[$next])) {
                    continue;
                }
                ?>
                <form method="post" action="<?= e(url('coaching/session.php?id=' . rawurlencode($slug))) ?>" data-choice-next="<?= e($next) ?>">
                    <input type="hidden" name="from_node" value="<?= e($nodeId) ?>">
                    <input type="hidden" name="choice_next" value="<?= e($next) ?>">
                    <input type="hidden" name="history" class="coaching-history-field" value="<?= e((string) $historyJson) ?>">
                    <button type="submit" class="coaching-choice"><?= e($label) ?></button>
                </form>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="coaching-actions">
        <?php if ($stepBackHref): ?>
            <a
                id="coaching-step-back"
                class="btn btn--ghost"
                href="<?= e($stepBackHref) ?>"
                <?php if ($rewindTo): ?>data-rewind-to="<?= e($rewindTo) ?>"<?php endif; ?>
            >Step back</a>
        <?php endif; ?>
        <?php if ($outcome === 'success' || $outcome === 'wrong'): ?>
            <a class="btn btn--primary" href="<?= e(url('coaching/session.php?id=' . rawurlencode($slug))) ?>">Restart session</a>
        <?php endif; ?>
    </div>

    <input type="hidden" id="coaching-history" value="<?= e((string) $historyJson) ?>">
</div>

<?php
layout_end();
