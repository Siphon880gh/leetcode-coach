<?php
declare(strict_types=1);

return [
    'title' => 'Nested List Weight Sum: integer times its nesting depth',
    'leetcode' => 339,
    'summary' => 'Walk a deterministic path: each NestedInteger is a number or a list. Depth is how many lists wrap it; the outer list starts at 1. Sum value × depth. [[1,1],2,[1,1]] → 10. [1,[4,[6]]] → 27. DFS with depth, or BFS a queue of (item, depth). Not 364 (that weights by maxDepth minus depth). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Depth-First Search',
    'topic' => 'LeetCode · Depth-First Search',
    'tags' => ['dfs', 'bfs', 'nested-list', 'step-by-step'],
    'related_guide' => 'nested-list-weight-sum',
];
