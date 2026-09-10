<?php
declare(strict_types=1);

return [
    'title' => 'Range Sum Query - Immutable: prefix s[right+1] minus s[left]',
    'leetcode' => 303,
    'summary' => 'Walk a deterministic path: array never changes. Precompute prefix sums with a dummy 0 at the front. Inclusive sum from left to right is s[right+1] − s[left]. O(1) per query. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Prefix Sum',
    'topic' => 'LeetCode · Prefix Sum',
    'tags' => ['prefix-sum', 'design', 'arrays', 'step-by-step'],
    'related_guide' => 'range-sum-query-immutable',
];
