<?php
declare(strict_types=1);

return [
    'title' => 'LCA of a Binary Tree: both sides hit means this node',
    'leetcode' => 236,
    'summary' => 'No BST order. Recurse left and right. If the node is p or q, return it. If both sides return a hit, this node is the LCA; else bubble the nonempty side. A node may be an ancestor of itself.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'dfs', 'lca', 'leetcode'],
    'related_session' => 'lowest-common-ancestor-of-a-binary-tree',
];
