<?php
declare(strict_types=1);

return [
    'title' => 'Binary Tree Paths: DFS buffer, join at a leaf, then pop',
    'leetcode' => 257,
    'summary' => 'Walk a deterministic path: push the node’s value, join the buffer with “->” only at a leaf, recurse otherwise, then pop so siblings share the prefix. Not Path Sum II. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'dfs', 'backtracking', 'step-by-step'],
    'related_guide' => 'binary-tree-paths',
];
