<?php
declare(strict_types=1);

return [
    'title' => 'Largest BST Subtree: post-order min, max, and size',
    'leetcode' => 333,
    'summary' => 'Walk a deterministic path: return the node count of the largest subtree that is a BST. Each node returns (min, max, size) if it is a BST, else a poison range so ancestors cannot grow through it. Null is (inf, −inf, 0). [10,5,15,1,8,null,7] → 3. Not 98 on the whole tree. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'bst', 'depth-first-search', 'step-by-step'],
    'related_guide' => 'largest-bst-subtree',
];
