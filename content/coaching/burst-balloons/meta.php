<?php
declare(strict_types=1);

return [
    'title' => 'Burst Balloons: last balloon in the open interval',
    'leetcode' => 312,
    'summary' => 'Walk a deterministic path: pad nums with 1 on both ends. f[i][j] is max coins bursting strictly inside (i, j). The last burst k still sees arr[i] and arr[j], so add arr[i] times arr[k] times arr[j] plus the two subintervals. [3,1,5,8] → 167. Not greedy smallest-first. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'interval-dp', 'arrays', 'step-by-step'],
    'related_guide' => 'burst-balloons',
];
