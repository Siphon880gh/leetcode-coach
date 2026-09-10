<?php
declare(strict_types=1);

return [
    'title' => 'Nested List Weight Sum II: invert depth with maxDepth',
    'leetcode' => 364,
    'summary' => 'Walk a deterministic path: weight is maxDepth − depth + 1. Sum value × weight. [[1,1],2,[1,1]] → 8. [1,[4,[6]]] → 17. One DFS: s and 339-style ws, answer (maxDepth + 1) × s − ws. Not 339. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Depth-First Search',
    'topic' => 'LeetCode · Depth-First Search',
    'tags' => ['dfs', 'bfs', 'nested-list', 'step-by-step'],
    'related_guide' => 'nested-list-weight-sum-ii',
];
