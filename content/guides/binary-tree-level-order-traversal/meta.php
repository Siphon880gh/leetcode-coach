<?php
declare(strict_types=1);

return [
    'title' => 'Level order: BFS one level per snapshot',
    'leetcode' => 102,
    'summary' => 'Queue the root. Each round, freeze n = queue length, collect those n values left to right, enqueue their children. Empty tree is [].',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'bfs', 'queue', 'leetcode'],
    'related_session' => 'binary-tree-level-order-traversal',
];
