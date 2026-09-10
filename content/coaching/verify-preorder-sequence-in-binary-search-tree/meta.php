<?php
declare(strict_types=1);

return [
    'title' => 'Verify BST preorder: decreasing stack; last pop is the lower bound',
    'leetcode' => 255,
    'summary' => 'Walk a deterministic path: decreasing stack is the path. When the next value is larger, pop — those left subtrees are done. last is the floor: anything smaller after that is not a valid BST preorder. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'tags' => ['stack', 'bst', 'preorder', 'monotonic-stack', 'step-by-step'],
    'related_guide' => 'verify-preorder-sequence-in-binary-search-tree',
];
