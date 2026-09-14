<?php
declare(strict_types=1);

return [
    'title' => 'Sum of Left Leaves: add a left child only when it is a leaf',
    'leetcode' => 404,
    'difficulty' => 'Easy',
    'summary' => 'Walk a deterministic path: a left leaf is a leaf that is someone’s left child. Recurse the right subtree always. If the left child exists and has no children, add its value; else recurse left. [3,9,20,null,null,15,7] → 24. A single root → 0. Not 104. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'dfs', 'binary-tree', 'step-by-step'],
    'related_guide' => 'sum-of-left-leaves',
];
