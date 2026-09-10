<?php
declare(strict_types=1);

return [
    'title' => 'Kth smallest in a BST: inorder, stop when k hits 0',
    'leetcode' => 230,
    'summary' => 'Walk a deterministic path: BST inorder is sorted and 1-indexed. Walk the left spine, visit, decrement k, return that value when k becomes 0, then go right. Do not dump every node into a list first. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'bst', 'inorder', 'step-by-step'],
    'related_guide' => 'kth-smallest-element-in-a-bst',
];
