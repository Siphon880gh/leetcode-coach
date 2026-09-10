<?php
declare(strict_types=1);

return [
    'title' => 'Binary Tree Longest Consecutive Sequence: parent-to-child plus one',
    'leetcode' => 298,
    'summary' => 'Walk a deterministic path: a consecutive path goes only downward and each child is parent plus 1. DFS returns the run starting at this node. If the child is not plus one, reset to 1. Track a global max. 3-4-5 is length 3; 3-2-1 does not count. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'dfs', 'step-by-step'],
    'related_guide' => 'binary-tree-longest-consecutive-sequence',
];
