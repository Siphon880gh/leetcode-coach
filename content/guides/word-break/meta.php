<?php
declare(strict_types=1);

return [
    'title' => 'Word Break: prefix DP, reuse dict words',
    'leetcode' => 139,
    'summary' => 'Hash the dictionary. f[0] is true. f[i] if some segmented prefix plus a dict slice reaches i. Return the boolean f[n], not the splits.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'hash-table', 'strings', 'leetcode'],
    'related_session' => 'word-break',
];
