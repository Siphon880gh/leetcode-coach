<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/layout.php';

$guides = list_content('guides');

layout_start([
    'title' => 'Cursor AI Guides',
    'description' => 'Guides for system design, algorithms, and LeetCode — built to use with this app\'s codebase.',
    'active' => 'guides',
]);
?>

<div class="page-head">
    <h1>Cursor AI Guides</h1>
    <p>
        Lessons meant to be used with the codebase of this app. Each guide ends with a copyable Cursor prompt
        so you can generate a related mini-game or coaching session via the harness skill.
    </p>
</div>

<?php if ($guides === []): ?>
    <p class="empty-state">No guides yet. Prompt Cursor with <code>.agents/skills/harness</code> to create one under <code>content/guides/</code>.</p>
<?php else: ?>
    <ul class="content-list">
        <?php foreach ($guides as $item): ?>
            <?php
            $meta = $item['meta'];
            $href = url('guides/view.php?id=' . rawurlencode($item['slug']));
            $tags = $meta['tags'] ?? [];
            ?>
            <li>
                <a class="content-card" href="<?= e($href) ?>">
                    <p class="content-card__meta"><?= e((string) ($meta['topic'] ?? 'Guide')) ?></p>
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
