<?php
declare(strict_types=1);

return [
    'title' => 'Binary Tree Vertical Order Traversal: BFS by column',
    'leetcode' => 314,
    'summary' => 'Walk a deterministic path: column of root is 0; left −1, right +1. BFS so each column is already top-to-bottom and left-to-right. Then emit columns from leftmost to rightmost. [3,9,20,null,null,15,7] → [[9],[3,15],[20],[7]]. Not 987 (do not sort by value). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'bfs', 'dfs', 'step-by-step'],
    'related_guide' => 'binary-tree-vertical-order-traversal',
];
