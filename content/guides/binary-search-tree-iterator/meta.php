<?php
declare(strict_types=1);

return [
    'title' => 'BST iterator: stack the left spine, then pop',
    'leetcode' => 173,
    'summary' => 'Push the left chain in the constructor. next pops, then pushes that node’s right-then-left spine. Average O(1) next, O(h) extra.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'bst', 'stack', 'iterator', 'leetcode'],
    'related_session' => 'binary-search-tree-iterator',
];
