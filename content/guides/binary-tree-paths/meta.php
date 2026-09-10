<?php
declare(strict_types=1);

return [
    'title' => 'Binary Tree Paths: DFS buffer, join at a leaf, then pop',
    'leetcode' => 257,
    'summary' => 'Walk every root-to-leaf path. Push the node’s value, and when both children are null join the buffer with “->”. Recurse otherwise, then pop so siblings share the prefix.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'dfs', 'backtracking', 'leetcode'],
    'related_session' => 'binary-tree-paths',
];
