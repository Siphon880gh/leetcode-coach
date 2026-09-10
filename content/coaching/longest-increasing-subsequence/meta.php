<?php
declare(strict_types=1);

return [
    'title' => 'Longest Increasing Subsequence: best ending at i, then tails',
    'leetcode' => 300,
    'summary' => 'Walk a deterministic path: f[i] is the best strictly increasing subsequence ending at i. Scan earlier j with a smaller value. n log n keeps the smallest tail of each length. [10,9,2,5,3,7,101,18] → 4. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'binary-search', 'arrays', 'step-by-step'],
    'related_guide' => 'longest-increasing-subsequence',
];
