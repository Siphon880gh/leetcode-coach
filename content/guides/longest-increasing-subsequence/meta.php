<?php
declare(strict_types=1);

return [
    'title' => 'Longest Increasing Subsequence: best ending at i, then tails',
    'leetcode' => 300,
    'summary' => 'Length of a strictly increasing subsequence, not a subarray. f[i] is the best that ends at i: 1 plus max f[j] for earlier strictly smaller values. n log n: keep the smallest tail of each length.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'binary-search', 'arrays', 'leetcode'],
    'related_session' => 'longest-increasing-subsequence',
];
