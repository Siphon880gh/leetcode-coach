<?php
declare(strict_types=1);

return [
    'title' => 'Inorder Successor in BST: smallest key greater than p',
    'leetcode' => 285,
    'summary' => 'Walk from the root. If the node is greater than p, it is a candidate — remember it and go left for something smaller still above p. Else go right. Last candidate is the successor, or null.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'bst', 'inorder', 'leetcode'],
    'related_session' => 'inorder-successor-in-bst',
];
