<?php
declare(strict_types=1);

return [
    'title' => 'Verify BST preorder: decreasing stack; last pop is the lower bound',
    'leetcode' => 255,
    'summary' => 'Scan the unique preorder. A decreasing stack is the path. When the next value is larger, pop — those nodes are finished left subtrees. last is the floor: anything smaller after that is not a valid BST preorder.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'kind' => 'algo',
    'tags' => ['stack', 'bst', 'preorder', 'monotonic-stack', 'leetcode'],
    'related_session' => 'verify-preorder-sequence-in-binary-search-tree',
];
