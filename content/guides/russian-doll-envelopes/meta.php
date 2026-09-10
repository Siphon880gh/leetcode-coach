<?php
declare(strict_types=1);

return [
    'title' => 'Russian Doll Envelopes: sort width, LIS on height',
    'leetcode' => 354,
    'summary' => 'Fit envelopes only when both width and height are strictly larger; no rotation. Sort by width ascending and height descending on ties, then longest increasing subsequence on heights (patience / binary search). [[5,4],[6,4],[6,7],[2,3]] → 3. n up to 1e5, so not O(n²) DP.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'binary-search', 'sorting', 'lis', 'leetcode'],
    'related_session' => 'russian-doll-envelopes',
];
