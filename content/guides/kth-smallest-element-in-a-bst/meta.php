<?php
declare(strict_types=1);

return [
    'title' => 'Kth smallest in a BST: inorder, stop when k hits 0',
    'leetcode' => 230,
    'summary' => 'BST inorder is sorted and 1-indexed. Walk the left spine, visit, decrement k, return that value when k becomes 0, then go right. Do not dump every node into a list first.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'bst', 'inorder', 'leetcode'],
    'related_session' => 'kth-smallest-element-in-a-bst',
];
