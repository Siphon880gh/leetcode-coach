<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/layout.php';
require_once dirname(__DIR__) . '/includes/guide_md.php';

$slug = isset($_GET['id']) ? (string) $_GET['id'] : '';
$item = load_content('guides', $slug);

if ($item === null) {
    http_response_code(404);
    layout_start(['title' => 'Guide not found', 'active' => 'guides-algo']);
    echo '<p class="empty-state">Guide not found.</p>';
    echo '<a class="back-link" href="' . e(guide_list_url('algo')) . '">← Algo Guides</a>';
    layout_end();
    exit;
}

$meta = $item['meta'];
$kind = normalize_guide_kind($meta['kind'] ?? null);
$sectionLabel = guide_kind_label($kind);
$active = $kind === 'cursor' ? 'guides-cursor' : 'guides-algo';
$guideTitle = (string) ($meta['title'] ?? $slug);
$mdPath = $item['path'] . '/body.md';
$phpPath = $item['path'] . '/body.php';
$guideSourceMd = '';

layout_start([
    'title' => $guideTitle,
    'description' => (string) ($meta['summary'] ?? ''),
    'active' => $active,
]);
?>

<a class="back-link" href="<?= e(guide_list_url($kind)) ?>">← <?= e($sectionLabel) ?></a>

<div class="page-head">
    <?php render_content_crumb($meta, 'guides/index.php', ['kind' => $kind]); ?>
    <h1><?= e($guideTitle) ?></h1>
    <?php if ($kind === 'algo'): ?>
        <?php render_resource_head_chrome('guide', $meta, $slug, 'guides/index.php'); ?>
    <?php else: ?>
        <?php render_leetcode_row($meta); ?>
    <?php endif; ?>
    <p><?= e((string) ($meta['summary'] ?? '')) ?></p>
</div>

<article
    class="guide-body"
    <?php if ($kind === 'algo'): ?>
        data-guide-select="algo"
        data-guide-title="<?= e($guideTitle) ?>"
    <?php endif; ?>
>
<?php
if (is_file($mdPath)) {
    $markdown = file_get_contents($mdPath);
    if ($markdown === false) {
        echo '<p class="empty-state">Could not read body.md.</p>';
    } else {
        if ($kind === 'algo') {
            $guideSourceMd = guide_md_prompt_source($markdown);
        }
        $existingSession = $kind === 'algo' ? guide_existing_session_slug($meta, $slug) : null;
        $existingGame = $kind === 'algo' ? companion_existing_game_slug($meta, $slug) : null;
        echo render_guide_markdown($markdown, $existingSession, $existingGame);
    }
} elseif (is_file($phpPath)) {
    require $phpPath;
} else {
    echo '<p class="empty-state">This guide has no body.md (or body.php) yet.</p>';
}
?>
</article>

<?php if ($kind === 'algo'): ?>
<?php if ($guideSourceMd !== ''): ?>
<script type="application/json" id="guide-source-md"><?= json_encode($guideSourceMd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
<?php endif; ?>
<div id="guide-select-menu" class="guide-select-menu" hidden role="toolbar" aria-label="Selected text">
    <button type="button" class="guide-select-menu__btn" id="guide-select-generate">Generate Code</button>
    <button type="button" class="guide-select-menu__btn" id="guide-select-copy">Copy</button>
</div>

<svg class="app-icon-symbols" width="0" height="0" aria-hidden="true" focusable="false">
    <symbol id="icon-chatgpt" viewBox="0 0 512 512">
        <path d="M196.4 185.8l0-48.6c0-4.1 1.5-7.2 5.1-9.2l97.8-56.3c13.3-7.7 29.2-11.3 45.6-11.3 61.4 0 100.4 47.6 100.4 98.3 0 3.6 0 7.7-.5 11.8L343.3 111.1c-6.1-3.6-12.3-3.6-18.4 0L196.4 185.8zM424.7 375.2l0-116.2c0-7.2-3.1-12.3-9.2-15.9L287 168.4 329 144.3c3.6-2 6.7-2 10.2 0L437 200.7c28.2 16.4 47.1 51.2 47.1 85 0 38.9-23 74.8-59.4 89.6l0 0zM166.2 272.8l-42-24.6c-3.6-2-5.1-5.1-5.1-9.2l0-112.6c0-54.8 42-96.3 98.8-96.3 21.5 0 41.5 7.2 58.4 20L175.4 108.5c-6.1 3.6-9.2 8.7-9.2 15.9l0 148.5 0 0zm90.4 52.2l-60.2-33.8 0-71.7 60.2-33.8 60.2 33.8 0 71.7-60.2 33.8zm38.7 155.7c-21.5 0-41.5-7.2-58.4-20l100.9-58.4c6.1-3.6 9.2-8.7 9.2-15.9l0-148.5 42.5 24.6c3.6 2 5.1 5.1 5.1 9.2l0 112.6c0 54.8-42.5 96.3-99.3 96.3l0 0zM173.8 366.5L76.1 310.2c-28.2-16.4-47.1-51.2-47.1-85 0-39.4 23.6-74.8 59.9-89.6l0 116.7c0 7.2 3.1 12.3 9.2 15.9l128 74.2-42 24.1c-3.6 2-6.7 2-10.2 0zm-5.6 84c-57.9 0-100.4-43.5-100.4-97.3 0-4.1 .5-8.2 1-12.3l100.9 58.4c6.1 3.6 12.3 3.6 18.4 0l128.5-74.2 0 48.6c0 4.1-1.5 7.2-5.1 9.2l-97.8 56.3c-13.3 7.7-29.2 11.3-45.6 11.3l0 0zm127 60.9c62 0 113.7-44 125.4-102.4 57.3-14.9 94.2-68.6 94.2-123.4 0-35.8-15.4-70.7-43-95.7 2.6-10.8 4.1-21.5 4.1-32.3 0-73.2-59.4-128-128-128-13.8 0-27.1 2-40.4 6.7-23-22.5-54.8-36.9-89.6-36.9-62 0-113.7 44-125.4 102.4-57.3-14.8-94.2 68.6-94.2 123.4 0 35.8 15.4 70.7 43 95.7-2.6 10.8-4.1 21.5-4.1 32.3 0 73.2 59.4 128 128 128 13.8 0 27.1-2 40.4 6.7 23 22.5 54.8 36.9 89.6 36.9z"></path>
    </symbol>
    <symbol id="icon-claude" viewBox="0 0 512 512">
        <path d="M100.4 340.5l100.7-56.5 1.7-4.9-1.7-2.7-4.9 0-16.8-1-57.5-1.6-49.9-2.1-48.3-2.6-12.2-2.6-11.4-15 1.2-7.5 10.2-6.9 14.7 1.3c18.9 1.3 45.9 3.1 81 5.6l35.2 2.1 52.2 5.4 8.3 0 1.2-3.4-2.8-2.1-2.2-2.1-50.3-34.1-54.4-36-28.5-20.7-15.4-10.5-7.8-9.8-3.4-21.5 14-15.4 18.8 1.3 4.8 1.3 19 14.7 40.7 31.5 53.1 39.1 7.8 6.5 3.1-2.2 .4-1.6-3.5-5.8-28.9-52.2-30.8-53.1-13.7-22-3.6-13.2c-1.3-5.4-2.2-10-2.2-15.5l15.9-21.6 8.8-2.8 21.2 2.8 8.9 7.8 13.2 30.2 21.4 47.5 33.2 64.6 9.7 19.2 5.2 17.8 1.9 5.4 3.4 0 0-3.1 2.7-36.4 5-44.7 4.9-57.5 1.7-16.2 8-19.4 15.9-10.5 12.4 5.9 10.2 14.7-1.4 9.5-6.1 39.5-11.9 61.9-7.8 41.5 4.5 0 5.2-5.2 21-27.8 35.2-44.1 15.5-17.5 18.1-19.3 11.6-9.2 22 0 16.2 24.1-7.3 24.9-22.7 28.7-18.8 24.4-27 36.3-16.8 29 1.6 2.3 4-.4 60.9-13 32.9-5.9 39.3-6.7 17.8 8.3 1.9 8.4-7 17.2-42 10.4-49.2 9.8-73.3 17.3-.9 .7 1 1.3 33 3.1 14.1 .8 34.6 0 64.4 4.8 16.8 11.1 10.1 13.6-1.7 10.4-25.9 13.2c-15.5-3.7-54.4-12.9-116.6-27.7l-28-7-3.9 0 0 2.3 23.3 22.8 42.7 38.6 53.5 49.8 2.7 12.3-6.9 9.7-7.3-1-47-35.4-18.1-15.9-41.1-34.6-2.7 0 0 3.6 9.5 13.9 50 75.2 2.6 23-3.6 7.5-13 4.5-14.2-2.6-29.3-41.1-30.2-46.3-24.4-41.5-3 1.7-14.4 154.8-6.7 7.9-15.5 5.9-13-9.8-6.9-15.9 6.9-31.5 8.3-41.1 6.7-32.7 6.1-40.6 3.6-13.5-.2-.9-3 .4-30.6 42-46.5 62.9-36.8 39.4-8.8 3.5-15.3-7.9 1.4-14.1 8.5-12.6 50.9-64.8 30.7-40.2 19.8-23.2-.1-3.4-1.2 0-135.3 87.8-24.1 3.1-10.4-9.7 1.3-15.9 4.9-5.2 40.7-28-.1 .1 0 .1z"></path>
    </symbol>
</svg>

<div id="guide-gen-modal" class="modal" hidden>
    <div class="modal__backdrop" data-action="close-guide-gen-modal"></div>
    <div class="modal__panel modal__panel--wide" role="dialog" aria-modal="true" aria-labelledby="guide-gen-modal-title" tabindex="-1">
        <header class="modal__header">
            <h3 id="guide-gen-modal-title" class="modal__title">Generate code</h3>
        </header>
        <div class="import-modal__body">
            <div class="import-ai-panel">
                <p class="import-ai-panel__preview-label">Prompt preview</p>
                <pre id="guide-gen-preview" class="import-ai-panel__preview import-ai-panel__preview--tall"></pre>
                <div class="import-ai-panel__actions">
                    <button type="button" id="guide-gen-copy" class="import-ai-panel__copy">Copy prompt</button>
                    <span class="import-ai-panel__open-label">Open in</span>
                    <a href="https://chatgpt.com/" target="_blank" rel="noopener noreferrer" id="guide-gen-open-chatgpt" class="import-ai-panel__service"><svg class="import-ai-panel__service-icon import-ai-panel__service-icon--chatgpt" width="14" height="14" aria-hidden="true" focusable="false"><use href="#icon-chatgpt"></use></svg><span>ChatGPT</span></a>
                    <a href="https://claude.ai/new" target="_blank" rel="noopener noreferrer" id="guide-gen-open-claude" class="import-ai-panel__service"><svg class="import-ai-panel__service-icon import-ai-panel__service-icon--claude" width="14" height="14" aria-hidden="true" focusable="false"><use href="#icon-claude"></use></svg><span>Claude</span></a>
                    <button type="button" id="guide-gen-open-cursor" class="import-ai-panel__service" aria-expanded="false" aria-controls="guide-gen-cursor-note">
                        <span>Cursor</span>
                        <span class="guide-gen-cursor-i" aria-hidden="true">i</span>
                    </button>
                </div>
                <p id="guide-gen-cursor-note" class="guide-gen-cursor-note" hidden>Copy this prompt into Cursor for this repo. Use Ask Mode so it will not touch the codebase.</p>
            </div>
        </div>
        <footer class="modal__footer">
            <button type="button" id="guide-gen-modal-done" class="modal__done">Done</button>
        </footer>
    </div>
</div>
<?php endif; ?>

<?php
layout_end();
