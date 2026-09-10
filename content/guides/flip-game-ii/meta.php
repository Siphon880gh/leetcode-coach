<?php
declare(strict_types=1);

return [
    'title' => 'Flip Game II: win if some move leaves a losing position',
    'leetcode' => 294,
    'summary' => 'Same ++ to -- moves as Flip Game, but ask whether the first player can force a win. Memoized DFS on a plus-bit mask: you win if any flip leaves a state where dfs is false. “++++” is true via the middle cut; “+” is false.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'kind' => 'algo',
    'tags' => ['backtracking', 'memoization', 'game-theory', 'leetcode'],
    'related_session' => 'flip-game-ii',
];
