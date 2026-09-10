<?php
declare(strict_types=1);

return [
    'title' => 'Inorder Successor in BST: smallest key greater than p',
    'leetcode' => 285,
    'summary' => 'Walk a deterministic path: from the root, if the node is greater than p it is a candidate — remember it and go left. Else go right. Last candidate is the successor, or null. Not a full inorder dump. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'bst', 'inorder', 'step-by-step'],
    'related_guide' => 'inorder-successor-in-bst',
];
