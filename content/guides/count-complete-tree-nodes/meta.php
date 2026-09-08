<?php
declare(strict_types=1);

return [
    'title' => 'Count Complete Tree Nodes: full subtree is a power of two, recurse the rest',
    'leetcode' => 222,
    'summary' => 'The tree is complete. Compare left-spine heights of the two children. Equal heights: left is perfect — add 2^h and count the right. Else the right is perfect — add 2^{h−1} and count the left.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'binary-search', 'complete-tree', 'leetcode'],
    'related_session' => 'count-complete-tree-nodes',
];
