<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/layout.php';

$slug = isset($_GET['id']) ? (string) $_GET['id'] : '';
$item = load_content('coaching', $slug);
$tree = $item !== null ? load_coaching_tree($slug) : null;

if ($item === null || $tree === null) {
    http_response_code(404);
    layout_start(['title' => 'Session not found', 'active' => 'coaching']);
    echo '<p class="empty-state">Step-by-step session not found.</p>';
    echo '<a class="back-link" href="' . e(url('coaching/index.php')) . '">← Step-by-step</a>';
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

/**
 * Label of the choice on $fromId that leads to $toId.
 */
$coachingChoiceLabel = static function (array $nodes, string $fromId, string $toId): ?string {
    $from = $nodes[$fromId] ?? null;
    if (!is_array($from)) {
        return null;
    }
    foreach ($from['choices'] ?? [] as $choice) {
        if (!is_array($choice)) {
            continue;
        }
        if ((string) ($choice['next'] ?? '') === $toId) {
            $label = trim((string) ($choice['label'] ?? ''));
            return $label !== '' ? $label : null;
        }
    }
    return null;
};

/**
 * First line of a node message, trimmed for the path visualizer.
 */
$coachingMessagePreview = static function (string $text, int $max = 140): string {
    $line = trim(explode("\n", $text, 2)[0]);
    if (mb_strlen($line) > $max) {
        return rtrim(mb_substr($line, 0, $max - 1)) . '…';
    }
    return $line;
};

$pathIds = array_values(array_merge($history, [$nodeId]));
$pathTrail = [];
foreach ($pathIds as $i => $id) {
    $pathNode = isset($nodes[$id]) && is_array($nodes[$id]) ? $nodes[$id] : [];
    $isCurrent = $i === count($pathIds) - 1;
    $chosen = null;
    if (!$isCurrent && isset($pathIds[$i + 1])) {
        $chosen = $coachingChoiceLabel($nodes, $id, (string) $pathIds[$i + 1]);
    }
    $rewindOnStep = isset($pathNode['rewind_to']) ? (string) $pathNode['rewind_to'] : null;
    $pathTrail[] = [
        'id' => (string) $id,
        'preview' => $coachingMessagePreview((string) ($pathNode['message'] ?? '')),
        'message' => (string) ($pathNode['message'] ?? ''),
        'outcome' => (string) ($pathNode['outcome'] ?? 'continue'),
        'choice' => $chosen,
        'current' => $isCurrent,
        'rewind_to' => $rewindOnStep !== '' ? $rewindOnStep : null,
    ];
}
$pathDepth = count($history);
$pathAnswered = $pathDepth > 0;

$openChoices = [];
if ($outcome === 'continue' && is_array($choices)) {
    foreach ($choices as $choice) {
        if (!is_array($choice)) {
            continue;
        }
        $choiceLabel = trim((string) ($choice['label'] ?? ''));
        $choiceNext = (string) ($choice['next'] ?? '');
        if ($choiceLabel === '' || $choiceNext === '' || !isset($nodes[$choiceNext])) {
            continue;
        }
        $openChoices[] = $choiceLabel;
    }
}

$pathAiTags = [];
if (isset($meta['tags']) && is_array($meta['tags'])) {
    foreach ($meta['tags'] as $tag) {
        if (is_string($tag) && trim($tag) !== '') {
            $pathAiTags[] = trim($tag);
        }
    }
}

$pathAi = [
    'title' => (string) ($meta['title'] ?? $slug),
    'summary' => (string) ($meta['summary'] ?? ''),
    'topic' => (string) ($meta['topic'] ?? ''),
    'category' => (string) ($meta['category'] ?? ''),
    'subcategory' => (string) ($meta['subcategory'] ?? ''),
    'tags' => $pathAiTags,
    'current_id' => $nodeId,
    'outcome' => $outcome,
    'rewind_to' => $rewindTo,
    'open_choices' => $openChoices,
    'answered' => $pathAnswered,
    'steps' => array_map(static function (array $step): array {
        return [
            'id' => (string) $step['id'],
            'message' => (string) ($step['message'] ?? ''),
            'outcome' => (string) ($step['outcome'] ?? 'continue'),
            'choice' => $step['choice'],
            'current' => (bool) $step['current'],
            'rewind_to' => $step['rewind_to'] ?? null,
        ];
    }, $pathTrail),
];
$pathAiJson = json_encode($pathAi, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if (!is_string($pathAiJson)) {
    $pathAiJson = '{}';
}

$pathAiTabs = [
    'explain' => [
        'label' => 'Explain what I have done so far',
        'subtitle' => 'Plain English walkthrough of the steps you have taken so far',
        'hint' => 'Builds a prompt from your path so far. Copy it, then use ChatGPT or Claude for a walkthrough with side notes on keywords, concepts, and Big-O such as O(n·k).',
        'needs_answer' => true,
    ],
    'optimize' => [
        'label' => 'How to optimize what I have so far',
        'subtitle' => 'Tighten the approach you have already taken',
        'hint' => 'Builds a prompt from your path so far. Copy it, then use ChatGPT or Claude for ways to improve the work you already did.',
        'needs_answer' => true,
    ],
    'proceed' => [
        'label' => 'Answer the entire problem from this point',
        'subtitle' => 'The complete solution from where you are now',
        'hint' => 'Builds a prompt from this session. Copy it, then use ChatGPT or Claude for a full answer from this point on.',
        'needs_answer' => false,
    ],
];
$pathAiDefaultTab = $pathAnswered ? 'explain' : 'proceed';
$pathAiActiveTab = $pathAiTabs[$pathAiDefaultTab];

layout_start([
    'title' => (string) ($meta['title'] ?? $slug),
    'description' => (string) ($meta['summary'] ?? ''),
    'active' => 'coaching',
]);
?>

<a class="back-link" href="<?= e(url('coaching/index.php')) ?>">← Step-by-step</a>

<div class="page-head">
    <?php render_content_crumb($meta, 'coaching/index.php', []); ?>
    <h1><?= e((string) ($meta['title'] ?? $slug)) ?></h1>
</div>

<div
    id="coaching-session"
    class="coaching-panel"
    data-node="<?= e($nodeId) ?>"
    data-history-key="coaching-<?= e($slug) ?>"
>
    <p class="coaching-path">Step: <code><?= e($nodeId) ?></code><?php if ($pathDepth > 0): ?> · path depth <?= $pathDepth ?><?php endif; ?></p>

    <div class="coaching-visualizer-wrap" data-path-ai="<?= e($pathAiJson) ?>">
        <div class="coaching-visualizer__bar">
            <details class="coaching-visualizer">
                <summary class="coaching-visualizer__summary">
                    Path visualizer
                    <span class="coaching-visualizer__meta">
                        <?php if ($pathDepth === 0): ?>
                            start — no choices yet
                        <?php else: ?>
                            <?= $pathDepth ?> prior step<?= $pathDepth === 1 ? '' : 's' ?> · open to review choices
                        <?php endif; ?>
                    </span>
                </summary>
        <ol class="coaching-trail">
            <?php foreach ($pathTrail as $stepNum => $step): ?>
                <?php
                $liClass = 'coaching-trail__step';
                if ($step['current']) {
                    $liClass .= ' is-current';
                }
                if ($step['outcome'] === 'wrong') {
                    $liClass .= ' is-wrong';
                } elseif ($step['outcome'] === 'success') {
                    $liClass .= ' is-success';
                }
                ?>
                <li class="<?= e($liClass) ?>">
                    <div class="coaching-trail__head">
                        <span class="coaching-trail__index"><?= $stepNum + 1 ?></span>
                        <code class="coaching-trail__id"><?= e($step['id']) ?></code>
                        <?php if ($step['current']): ?>
                            <span class="coaching-trail__badge">Now</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($step['preview'] !== ''): ?>
                        <p class="coaching-trail__preview"><?= e($step['preview']) ?></p>
                    <?php endif; ?>
                    <?php if ($step['choice'] !== null): ?>
                        <p class="coaching-trail__choice">
                            <span class="coaching-trail__choice-label">You chose</span>
                            <?= e($step['choice']) ?>
                        </p>
                    <?php elseif (!$step['current']): ?>
                        <p class="coaching-trail__choice coaching-trail__choice--muted">Continued</p>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>
            </details>
            <button
                type="button"
                id="coaching-path-ai-open"
                class="coaching-ai-open"
                aria-haspopup="dialog"
                aria-controls="coaching-path-ai-modal"
                aria-label="Ask AI about this path"
            >
                <span class="coaching-ai-open__icon" aria-hidden="true">✨</span>
                <span>Ask AI</span>
            </button>
        </div>
    </div>

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

<svg class="app-icon-symbols" width="0" height="0" aria-hidden="true" focusable="false">
    <symbol id="icon-chatgpt" viewBox="0 0 512 512">
        <path d="M196.4 185.8l0-48.6c0-4.1 1.5-7.2 5.1-9.2l97.8-56.3c13.3-7.7 29.2-11.3 45.6-11.3 61.4 0 100.4 47.6 100.4 98.3 0 3.6 0 7.7-.5 11.8L343.3 111.1c-6.1-3.6-12.3-3.6-18.4 0L196.4 185.8zM424.7 375.2l0-116.2c0-7.2-3.1-12.3-9.2-15.9L287 168.4 329 144.3c3.6-2 6.7-2 10.2 0L437 200.7c28.2 16.4 47.1 51.2 47.1 85 0 38.9-23 74.8-59.4 89.6l0 0zM166.2 272.8l-42-24.6c-3.6-2-5.1-5.1-5.1-9.2l0-112.6c0-54.8 42-96.3 98.8-96.3 21.5 0 41.5 7.2 58.4 20L175.4 108.5c-6.1 3.6-9.2 8.7-9.2 15.9l0 148.5 0 0zm90.4 52.2l-60.2-33.8 0-71.7 60.2-33.8 60.2 33.8 0 71.7-60.2 33.8zm38.7 155.7c-21.5 0-41.5-7.2-58.4-20l100.9-58.4c6.1-3.6 9.2-8.7 9.2-15.9l0-148.5 42.5 24.6c3.6 2 5.1 5.1 5.1 9.2l0 112.6c0 54.8-42.5 96.3-99.3 96.3l0 0zM173.8 366.5L76.1 310.2c-28.2-16.4-47.1-51.2-47.1-85 0-39.4 23.6-74.8 59.9-89.6l0 116.7c0 7.2 3.1 12.3 9.2 15.9l128 74.2-42 24.1c-3.6 2-6.7 2-10.2 0zm-5.6 84c-57.9 0-100.4-43.5-100.4-97.3 0-4.1 .5-8.2 1-12.3l100.9 58.4c6.1 3.6 12.3 3.6 18.4 0l128.5-74.2 0 48.6c0 4.1-1.5 7.2-5.1 9.2l-97.8 56.3c-13.3 7.7-29.2 11.3-45.6 11.3l0 0zm127 60.9c62 0 113.7-44 125.4-102.4 57.3-14.9 94.2-68.6 94.2-123.4 0-35.8-15.4-70.7-43-95.7 2.6-10.8 4.1-21.5 4.1-32.3 0-73.2-59.4-128-128-128-13.8 0-27.1 2-40.4 6.7-23-22.5-54.8-36.9-89.6-36.9-62 0-113.7 44-125.4 102.4-57.3 14.8-94.2 68.6-94.2 123.4 0 35.8 15.4 70.7 43 95.7-2.6 10.8-4.1 21.5-4.1 32.3 0 73.2 59.4 128 128 128 13.8 0 27.1-2 40.4 6.7 23 22.5 54.8 36.9 89.6 36.9z"></path>
    </symbol>
    <symbol id="icon-claude" viewBox="0 0 512 512">
        <path d="M100.4 340.5l100.7-56.5 1.7-4.9-1.7-2.7-4.9 0-16.8-1-57.5-1.6-49.9-2.1-48.3-2.6-12.2-2.6-11.4-15 1.2-7.5 10.2-6.9 14.7 1.3c18.9 1.3 45.9 3.1 81 5.6l35.2 2.1 52.2 5.4 8.3 0 1.2-3.4-2.8-2.1-2.2-2.1-50.3-34.1-54.4-36-28.5-20.7-15.4-10.5-7.8-9.8-3.4-21.5 14-15.4 18.8 1.3 4.8 1.3 19 14.7 40.7 31.5 53.1 39.1 7.8 6.5 3.1-2.2 .4-1.6-3.5-5.8-28.9-52.2-30.8-53.1-13.7-22-3.6-13.2c-1.3-5.4-2.2-10-2.2-15.5l15.9-21.6 8.8-2.8 21.2 2.8 8.9 7.8 13.2 30.2 21.4 47.5 33.2 64.6 9.7 19.2 5.2 17.8 1.9 5.4 3.4 0 0-3.1 2.7-36.4 5-44.7 4.9-57.5 1.7-16.2 8-19.4 15.9-10.5 12.4 5.9 10.2 14.7-1.4 9.5-6.1 39.5-11.9 61.9-7.8 41.5 4.5 0 5.2-5.2 21-27.8 35.2-44.1 15.5-17.5 18.1-19.3 11.6-9.2 22 0 16.2 24.1-7.3 24.9-22.7 28.7-18.8 24.4-27 36.3-16.8 29 1.6 2.3 4-.4 60.9-13 32.9-5.9 39.3-6.7 17.8 8.3 1.9 8.4-7 17.2-42 10.4-49.2 9.8-73.3 17.3-.9 .7 1 1.3 33 3.1 14.1 .8 34.6 0 64.4 4.8 16.8 11.1 10.1 13.6-1.7 10.4-25.9 13.2c-15.5-3.7-54.4-12.9-116.6-27.7l-28-7-3.9 0 0 2.3 23.3 22.8 42.7 38.6 53.5 49.8 2.7 12.3-6.9 9.7-7.3-1-47-35.4-18.1-15.9-41.1-34.6-2.7 0 0 3.6 9.5 13.9 50 75.2 2.6 23-3.6 7.5-13 4.5-14.2-2.6-29.3-41.1-30.2-46.3-24.4-41.5-3 1.7-14.4 154.8-6.7 7.9-15.5 5.9-13-9.8-6.9-15.9 6.9-31.5 8.3-41.1 6.7-32.7 6.1-40.6 3.6-13.5-.2-.9-3 .4-30.6 42-46.5 62.9-36.8 39.4-8.8 3.5-15.3-7.9 1.4-14.1 8.5-12.6 50.9-64.8 30.7-40.2 19.8-23.2-.1-3.4-1.2 0-135.3 87.8-24.1 3.1-10.4-9.7 1.3-15.9 4.9-5.2 40.7-28-.1 .1 0 .1z"></path>
    </symbol>
</svg>

<div id="coaching-path-ai-modal" class="modal" hidden>
    <div class="modal__backdrop" data-action="close-coaching-path-ai-modal"></div>
    <div class="modal__panel modal__panel--wide" role="dialog" aria-modal="true" aria-labelledby="coaching-path-ai-modal-title">
        <header class="modal__header">
            <h3 id="coaching-path-ai-modal-title" class="modal__title">Ask AI</h3>
            <p id="coaching-path-ai-modal-subtitle" class="modal__subtitle"><?= e((string) $pathAiActiveTab['subtitle']) ?></p>
            <div class="coaching-path-ai-tabs" role="tablist" aria-label="Ask AI prompt">
                <?php foreach ($pathAiTabs as $tabId => $tab): ?>
                    <?php
                    $tabDisabled = (bool) $tab['needs_answer'] && !$pathAnswered;
                    $tabSelected = $tabId === $pathAiDefaultTab;
                    ?>
                    <button
                        type="button"
                        role="tab"
                        class="coaching-path-ai-tab"
                        id="coaching-path-ai-tab-<?= e((string) $tabId) ?>"
                        data-path-ai-tab="<?= e((string) $tabId) ?>"
                        data-subtitle="<?= e((string) $tab['subtitle']) ?>"
                        data-hint="<?= e((string) $tab['hint']) ?>"
                        aria-controls="coaching-path-ai-panel"
                        aria-selected="<?= $tabSelected ? 'true' : 'false' ?>"
                        tabindex="<?= $tabSelected ? '0' : '-1' ?>"
                        <?php if ($tabDisabled): ?>disabled title="Answer a step first"<?php endif; ?>
                    ><?= e((string) $tab['label']) ?></button>
                <?php endforeach; ?>
            </div>
        </header>
        <div class="import-modal__body">
            <p id="coaching-path-ai-hint" class="import-modal__hint"><?= e((string) $pathAiActiveTab['hint']) ?></p>
            <div id="coaching-path-ai-panel" class="import-ai-panel" role="tabpanel" aria-labelledby="coaching-path-ai-tab-<?= e((string) $pathAiDefaultTab) ?>">
                <p class="import-ai-panel__preview-label">Prompt preview</p>
                <pre id="coaching-path-ai-preview" class="import-ai-panel__preview import-ai-panel__preview--tall"></pre>
                <div class="import-ai-panel__actions">
                    <button type="button" id="coaching-path-ai-copy" class="import-ai-panel__copy">Copy prompt</button>
                    <span class="import-ai-panel__open-label">Open in</span>
                    <a href="https://chatgpt.com/" target="_blank" rel="noopener noreferrer" id="coaching-path-open-chatgpt" class="import-ai-panel__service"><svg class="import-ai-panel__service-icon import-ai-panel__service-icon--chatgpt" width="14" height="14" aria-hidden="true" focusable="false"><use href="#icon-chatgpt"></use></svg><span>ChatGPT</span></a>
                    <a href="https://claude.ai/new" target="_blank" rel="noopener noreferrer" id="coaching-path-open-claude" class="import-ai-panel__service"><svg class="import-ai-panel__service-icon import-ai-panel__service-icon--claude" width="14" height="14" aria-hidden="true" focusable="false"><use href="#icon-claude"></use></svg><span>Claude</span></a>
                </div>
            </div>
        </div>
        <footer class="modal__footer">
            <button type="button" id="coaching-path-ai-modal-done" class="modal__done">Done</button>
        </footer>
    </div>
</div>

<?php
layout_end();
