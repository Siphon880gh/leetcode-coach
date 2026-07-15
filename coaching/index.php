<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/layout.php';

$sessions = list_content('coaching');

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

<?php if ($sessions === []): ?>
    <p class="empty-state">No step-by-step sessions yet. Prompt Cursor with <code>.agents/skills/harness</code> to create one under <code>content/coaching/</code>.</p>
<?php else: ?>
    <ul class="content-list">
        <?php foreach ($sessions as $item): ?>
            <?php
            $meta = $item['meta'];
            $href = url('coaching/session.php?id=' . rawurlencode($item['slug']));
            $tags = $meta['tags'] ?? [];
            ?>
            <li>
                <a class="content-card" href="<?= e($href) ?>">
                    <p class="content-card__meta"><?= e((string) ($meta['topic'] ?? 'Step-by-step')) ?></p>
                    <h2 class="content-card__title"><?= e((string) ($meta['title'] ?? $item['slug'])) ?></h2>
                    <p class="content-card__desc"><?= e((string) ($meta['summary'] ?? '')) ?></p>
                    <?php if (is_array($tags) && $tags !== []): ?>
                        <div class="tags">
                            <?php foreach ($tags as $tag): ?>
                                <span class="tag"><?= e((string) $tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
layout_end();
