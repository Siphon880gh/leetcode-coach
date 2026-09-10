<?php
declare(strict_types=1);

return [
    'title' => 'Closest Binary Search Tree Value: walk like binary search, keep the closer',
    'leetcode' => 270,
    'summary' => 'One root-to-leaf path. At each node, if this value is closer to target (or tied and smaller), remember it. Then go left if target is smaller, else right. Sample tree [4,2,5,1,3], target ≈ 3.71 → 4.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'bst', 'binary-search', 'leetcode'],
    'related_session' => 'closest-binary-search-tree-value',
];
