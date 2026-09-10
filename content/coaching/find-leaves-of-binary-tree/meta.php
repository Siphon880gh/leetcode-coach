<?php
declare(strict_types=1);

return [
    'title' => 'Find Leaves of Binary Tree: group by height from the leaves',
    'leetcode' => 366,
    'summary' => 'Walk a deterministic path: collect current leaves, remove them, repeat. Height-from-leaves: a leaf is 0, a parent is 1 + max of children. Append val into ans[h]. [1,2,3,4,5] → [[4,5,3],[2],[1]]. Not root-to-leaf level order. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'dfs', 'binary-tree', 'step-by-step'],
    'related_guide' => 'find-leaves-of-binary-tree',
];
