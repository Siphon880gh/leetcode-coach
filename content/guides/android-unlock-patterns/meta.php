<?php
declare(strict_types=1);

return [
    'title' => 'Android Unlock Patterns: DFS with knight-jump midpoints',
    'leetcode' => 351,
    'summary' => '3×3 dots. Count unique sequences of length in [m, n]. Distinct dots. A hop that crosses another dot’s center is legal only if that midpoint was already used. Backtrack; 4 corners and 4 edges are symmetric. m=n=1 → 9.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'kind' => 'algo',
    'tags' => ['backtracking', 'dfs', 'symmetry', 'leetcode'],
    'related_session' => 'android-unlock-patterns',
];
