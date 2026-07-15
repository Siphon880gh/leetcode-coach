<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/layout.php';

$games = list_content('games');

layout_start([
    'title' => 'Mini games',
    'description' => 'Small games that make algorithm theory and LeetCode problems tangible.',
    'active' => 'games',
]);
?>

<div class="page-head">
    <h1>Mini games</h1>
    <p>
        Short interactive games that help a theory or problem click. New games are authored with the harness skill
        (and may use <code>.agents/skills/game-development-sickn33</code> for game craft).
    </p>
</div>

<?php if ($games === []): ?>
    <p class="empty-state">No games yet. Prompt Cursor with <code>.agents/skills/harness</code> to create one under <code>content/games/</code>.</p>
<?php else: ?>
    <ul class="content-list">
        <?php foreach ($games as $item): ?>
            <?php
            $meta = $item['meta'];
            $href = url('games/play.php?id=' . rawurlencode($item['slug']));
            $tags = $meta['tags'] ?? [];
            ?>
            <li>
                <a class="content-card" href="<?= e($href) ?>">
                    <p class="content-card__meta"><?= e((string) ($meta['topic'] ?? 'Mini game')) ?></p>
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
