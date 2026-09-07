<?php
declare(strict_types=1);

return [
    'title' => 'Min depth: shortest path to a real leaf',
    'leetcode' => 111,
    'summary' => 'A leaf has no children. If one side is missing, recurse only on the other. Blind 1 + min(left, right) treats a null child as a leaf.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'dfs', 'recursion', 'leetcode'],
    'related_session' => 'minimum-depth-of-binary-tree',
];
