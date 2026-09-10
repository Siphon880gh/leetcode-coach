<?php
declare(strict_types=1);

return [
    'title' => 'House Robber III: pair of rob / skip at each node',
    'leetcode' => 337,
    'summary' => 'Walk a deterministic path: binary tree of houses. Adjacent (parent–child) cannot both be robbed. Post-order: (take this node plus skip on both children, skip this node plus the better choice on each child). Answer is the max of the two at the root. [3,2,3,null,3,null,1] → 7. Not 198’s linear scan. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'trees', 'dfs', 'step-by-step'],
    'related_guide' => 'house-robber-iii',
];
