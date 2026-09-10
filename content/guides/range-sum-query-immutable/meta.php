<?php
declare(strict_types=1);

return [
    'title' => 'Range Sum Query - Immutable: prefix s[right+1] minus s[left]',
    'leetcode' => 303,
    'summary' => 'Array never changes. Precompute prefix sums with a dummy 0 at the front. Inclusive sum from left to right is s[right+1] − s[left]. O(1) per query. Not Fenwick, not a loop per call.',
    'category' => 'LeetCode',
    'subcategory' => 'Prefix Sum',
    'topic' => 'LeetCode · Prefix Sum',
    'kind' => 'algo',
    'tags' => ['prefix-sum', 'design', 'arrays', 'leetcode'],
    'related_session' => 'range-sum-query-immutable',
];
