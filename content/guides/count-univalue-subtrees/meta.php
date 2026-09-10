<?php
declare(strict_types=1);

return [
    'title' => 'Count Univalue Subtrees: postorder, a node counts if both sides match',
    'leetcode' => 250,
    'summary' => 'A subtree is univalue when every node in it has the same value. Recurse: both children must themselves be univalue, and each present child’s value must equal this node. Leaves count. Empty tree is 0.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'dfs', 'recursion', 'leetcode'],
    'related_session' => 'count-univalue-subtrees',
];
