<?php
declare(strict_types=1);

return [
    'title' => 'Binary Tree Upside Down: flip along the left spine',
    'leetcode' => 156,
    'summary' => 'Recurse the left chain, then rewire: old left’s right is this node, old left’s left is the old right. Null this node’s kids and return the leftmost.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'dfs', 'binary-tree', 'leetcode'],
    'related_session' => 'binary-tree-upside-down',
];
