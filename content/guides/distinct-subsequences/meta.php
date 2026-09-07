<?php
declare(strict_types=1);

return [
    'title' => 'Distinct subsequences: ways s can form t',
    'leetcode' => 115,
    'summary' => 'f[i][j] counts ways the first i of s form the first j of t. Always skip; also take when letters match. Empty t is 1 way.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'strings', 'subsequence', 'leetcode'],
    'related_session' => 'distinct-subsequences',
];
