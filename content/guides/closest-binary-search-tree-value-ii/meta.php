<?php
declare(strict_types=1);

return [
    'title' => 'Closest Binary Search Tree Value II: inorder window of k neighbors',
    'leetcode' => 272,
    'summary' => 'Return the k BST values closest to target. Inorder is sorted. Keep a deque of k consecutive values. When the next value is no closer than the left of the window, prune the rest of the tree. Not the single closest (270).',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'bst', 'inorder', 'sliding-window', 'leetcode'],
    'related_session' => 'closest-binary-search-tree-value-ii',
];
