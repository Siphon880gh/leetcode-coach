<?php
declare(strict_types=1);

return [
    'title' => 'Nested List Weight Sum II: invert depth with maxDepth',
    'leetcode' => 364,
    'summary' => 'Weight of an integer is maxDepth − depth + 1. Sum value × weight. [[1,1],2,[1,1]] → 8. [1,[4,[6]]] → 17. One DFS: track maxDepth, s (sum of values), ws (339-style value × depth). Answer is (maxDepth + 1) × s − ws. Not 339 (that uses raw depth). Not flatten then times 1.',
    'category' => 'LeetCode',
    'subcategory' => 'Depth-First Search',
    'topic' => 'LeetCode · Depth-First Search',
    'kind' => 'algo',
    'tags' => ['dfs', 'bfs', 'nested-list', 'leetcode'],
    'related_session' => 'nested-list-weight-sum-ii',
];
