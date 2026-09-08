<?php
declare(strict_types=1);

return [
    'title' => 'Count Complete Tree Nodes: full subtree is a power of two, recurse the rest',
    'leetcode' => 222,
    'summary' => 'Walk a deterministic path: the tree is complete. Compare left-spine heights of the two children. Equal heights: left is perfect — add 2^h and count the right. Else the right is perfect — add 2^{h−1} and count the left. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'binary-search', 'complete-tree', 'step-by-step'],
    'related_guide' => 'count-complete-tree-nodes',
];
