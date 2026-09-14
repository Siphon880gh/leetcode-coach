<?php
declare(strict_types=1);

return [
    'title' => 'N-ary Tree Level Order Traversal: BFS one level at a time, extend all children',
    'leetcode' => 429,
    'difficulty' => 'Med',
    'summary' => 'Empty root → empty list. Queue the root. For each snapshot of the queue length, pop that many nodes, collect their values, and enqueue every child (not just two). [1,null,3,2,4,null,5,6] → [[1],[3,2,4],[5,6]]. Not 102 (binary). Not 428 (round-trip string).',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'bfs', 'n-ary-tree', 'leetcode'],
];
