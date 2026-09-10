<?php
declare(strict_types=1);

return [
    'title' => 'Russian Doll Envelopes: sort width, LIS on height',
    'leetcode' => 354,
    'summary' => 'Walk a deterministic path: nest only when both sides are strictly larger. Sort width up and height down on ties, then patience LIS on heights. [[5,4],[6,4],[6,7],[2,3]] → 3. n is 1e5, so not quadratic DP. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'binary-search', 'sorting', 'lis', 'step-by-step'],
    'related_guide' => 'russian-doll-envelopes',
];
