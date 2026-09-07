<?php
declare(strict_types=1);

return [
    'title' => 'Build tree: postorder last is root',
    'leetcode' => 106,
    'summary' => 'The last value in the current postorder slice is the root. Hash inorder, skip the left block, recurse both sides. Not 105’s first-of-preorder.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'divide-and-conquer', 'hash-table', 'leetcode'],
    'related_session' => 'construct-binary-tree-from-inorder-and-postorder-traversal',
];
