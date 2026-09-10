<?php
declare(strict_types=1);

return [
    'title' => 'LCA of a BST: walk until p and q split',
    'leetcode' => 235,
    'summary' => 'Walk a deterministic path: from the root, if both p and q are smaller go left; if both are larger go right; otherwise this node is the split — the LCA. A node may be an ancestor of itself. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'bst', 'lca', 'step-by-step'],
    'related_guide' => 'lowest-common-ancestor-of-a-binary-search-tree',
];
