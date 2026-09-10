<?php
declare(strict_types=1);

return [
    'title' => 'Closest Binary Search Tree Value: walk like binary search, keep the closer',
    'leetcode' => 270,
    'summary' => 'Walk a deterministic path: one root-to-leaf search. Update ans when this value is closer, or tied and smaller. Then go left if target is smaller, else right. Sample ≈ 3.71 → 4. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'bst', 'binary-search', 'step-by-step'],
    'related_guide' => 'closest-binary-search-tree-value',
];
