<?php
declare(strict_types=1);

return [
    'title' => 'Binary Tree Maximum Path Sum: bend, then one side up',
    'leetcode' => 124,
    'summary' => 'DFS: clamp negative children to 0, update a global with both sides plus val, return val plus the better child. Init the global to -inf.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'dfs', 'path-sum', 'leetcode'],
    'related_session' => 'binary-tree-maximum-path-sum',
];
