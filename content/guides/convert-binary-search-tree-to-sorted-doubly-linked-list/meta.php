<?php
declare(strict_types=1);

return [
    'title' => 'Convert BST to Sorted Doubly Linked List: inorder stitch, then close the circle',
    'leetcode' => 426,
    'difficulty' => 'Med',
    'summary' => 'In-place: reuse left as prev and right as next. Inorder walk stitches each node to the previous visit. The first visit is the smallest (head). After the walk, link last to first so the list is circular. [4,2,5,1,3] → 1↔2↔3↔4↔5↔1. Empty → null. Not 114 (flatten to a right spine).',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'bst', 'linked-list', 'leetcode'],
];
