<?php
declare(strict_types=1);

return [
    'title' => 'Count Univalue Subtrees: postorder, a node counts if both sides match',
    'leetcode' => 250,
    'summary' => 'Walk a deterministic path: dfs returns whether this subtree is all one value. Null is true but does not increment. Both children must be univalue and equal this node. Leaves count. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'dfs', 'recursion', 'step-by-step'],
    'related_guide' => 'count-univalue-subtrees',
];
