<?php
declare(strict_types=1);

return [
    'title' => 'Water and Jug Problem: target is a multiple of gcd',
    'leetcode' => 365,
    'summary' => 'Walk a deterministic path: fill, empty, or pour. True iff some state has total (or one jug) equal to target. Bézout: target ≤ x+y and target is a multiple of gcd(x, y) (target 0 is true). 3,5,4 → true. 2,6,5 → false. 1,2,3 → true. Not greedy fill of the larger jug only. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'tags' => ['math', 'gcd', 'bfs', 'dfs', 'step-by-step'],
    'related_guide' => 'water-and-jug-problem',
];
