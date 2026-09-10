<?php
declare(strict_types=1);

return [
    'title' => 'Closest Binary Search Tree Value II: inorder window of k neighbors',
    'leetcode' => 272,
    'summary' => 'Walk a deterministic path: inorder is sorted, so the k closest sit in a consecutive window. Keep a deque of k values. When the next is no closer than the left of the window, prune. Not 270’s single closest. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'bst', 'inorder', 'sliding-window', 'step-by-step'],
    'related_guide' => 'closest-binary-search-tree-value-ii',
];
