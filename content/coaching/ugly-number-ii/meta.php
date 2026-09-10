<?php
declare(strict_types=1);

return [
    'title' => 'Ugly Number II: three pointers merge 2, 3, 5',
    'leetcode' => 264,
    'summary' => 'Walk a deterministic path: dp[0] = 1; next is min of dp[p2]×2, dp[p3]×3, dp[p5]×5; bump every pointer that hit that min so 6 is not duplicated. 10 → 12. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'heap', 'math', 'step-by-step'],
    'related_guide' => 'ugly-number-ii',
];
