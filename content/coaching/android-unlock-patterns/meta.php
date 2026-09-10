<?php
declare(strict_types=1);

return [
    'title' => 'Android Unlock Patterns: DFS with knight-jump midpoints',
    'leetcode' => 351,
    'summary' => 'Walk a deterministic path: 3 by 3 dots. Count unique sequences of length in [m, n]. Distinct dots. A hop that crosses another dot’s center is legal only if that midpoint was already used. Backtrack; 4 corners and 4 edges are symmetric. m=n=1 → 9. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'tags' => ['backtracking', 'dfs', 'symmetry', 'step-by-step'],
    'related_guide' => 'android-unlock-patterns',
];
