<?php
declare(strict_types=1);

return [
    'title' => 'Build tree: preorder root, split inorder',
    'leetcode' => 105,
    'summary' => 'preorder[i] is the root. Hash inorder indices, split left size at that index, recurse both slices. Return the reconstructed root.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'divide-and-conquer', 'hash-table', 'leetcode'],
    'related_session' => 'construct-binary-tree-from-preorder-and-inorder-traversal',
];
