<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/layout.php';

$games = list_content('games');
$cat = isset($_GET['cat']) ? trim((string) $_GET['cat']) : '';
$sub = isset($_GET['sub']) ? trim((string) $_GET['sub']) : '';

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

<?php
render_content_browse($games, [
    'script' => 'games/index.php',
    'query' => [],
    'cat' => $cat,
    'sub' => $sub,
    'user_tags' => true,
    'empty' => 'No games yet. Prompt Cursor with <code>.agents/skills/harness</code> to create one under <code>content/games/</code>.',
    'item_href' => static function (array $item): string {
        return url('games/play.php?id=' . rawurlencode($item['slug']));
    },
]);

layout_end();
