<?php
declare(strict_types=1);

return [
    'title' => 'Pacific Atlantic Water Flow: reverse BFS uphill from both oceans',
    'leetcode' => 417,
    'difficulty' => 'Med',
    'summary' => 'Cells that can drain to both oceans. Pacific is top and left; Atlantic is bottom and right. Water flows to a neighbor of height less than or equal. Search inland from each ocean (neighbor height greater or equal), then take the intersection. [[1]] → [[0,0]]. Not 200 (islands). Not 130 (surrounded).',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'kind' => 'algo',
    'tags' => ['graphs', 'bfs', 'dfs', 'matrix', 'leetcode'],
];
