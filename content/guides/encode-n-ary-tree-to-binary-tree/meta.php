<?php
declare(strict_types=1);

return [
    'title' => 'Encode N-ary Tree to Binary Tree: left is first child, right is next sibling',
    'leetcode' => 431,
    'difficulty' => 'Hard',
    'summary' => 'Map an N-ary tree to a binary tree and back, stateless. Left pointer = first child. Right pointer = next sibling. Decode walks the right chain from left and recurses. Empty → empty. Not 428 (string codec). Not 297 (binary nulls).',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'dfs', 'binary-tree', 'leetcode'],
];
