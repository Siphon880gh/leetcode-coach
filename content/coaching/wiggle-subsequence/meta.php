<?php
declare(strict_types=1);

return [
    'title' => 'Wiggle Subsequence: up/down DP, then one-pass peaks',
    'leetcode' => 376,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: longest subsequence whose successive diffs strictly alternate sign. f[i] ends on an up, g[i] on a down. Equals never extend. [1,7,4,9,2,5] → 6; a rising run → 2. Follow-up: two running lengths. Not 280. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'greedy', 'arrays', 'step-by-step'],
    'related_guide' => 'wiggle-subsequence',
];
