<?php
declare(strict_types=1);

return [
    'title' => 'Flip Game II: win if some move leaves a losing position',
    'leetcode' => 294,
    'summary' => 'Walk a deterministic path: same ++ to -- moves as Flip Game, but ask whether the first player can force a win. Memoized DFS on a plus-bit mask: you win if any flip leaves a state where dfs is false. “++++” is true via the middle cut; “+” is false. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'tags' => ['backtracking', 'memoization', 'game-theory', 'step-by-step'],
    'related_guide' => 'flip-game-ii',
];
