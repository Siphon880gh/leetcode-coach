<?php
declare(strict_types=1);

return [
    'title' => 'Invert Binary Tree: swap left and right at every node',
    'leetcode' => 226,
    'summary' => 'Walk a deterministic path: mirror the tree in place. Recurse both children, then assign left to the inverted right and right to the inverted left. Empty stays empty. BFS swap at each node is the same idea. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'dfs', 'bfs', 'step-by-step'],
    'related_guide' => 'invert-binary-tree',
];
