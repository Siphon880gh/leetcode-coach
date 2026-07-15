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

<?php if ($guides === []): ?>
    <p class="empty-state">
        No guides in this section yet. Prompt Cursor with <code>.agents/skills/harness</code>
        to create one under <code>content/guides/</code> with <code>kind => '<?= e($kind) ?>'</code>.
    </p>
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
