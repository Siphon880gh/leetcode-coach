<?php
declare(strict_types=1);

return [
    'title' => 'Validate BST: inorder must strictly increase',
    'leetcode' => 98,
    'summary' => 'Walk inorder with prev starting at −∞. Reject prev ≥ val. A local left/right child check misses far descendants.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'bst', 'inorder', 'leetcode'],
    'related_session' => 'validate-binary-search-tree',
];
