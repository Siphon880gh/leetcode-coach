<?php
declare(strict_types=1);

return [
    'title' => 'Number of Connected Components in an Undirected Graph: DFS or union-find',
    'leetcode' => 323,
    'summary' => 'Walk a deterministic path: n nodes, undirected edges. Each unvisited start is a new component (DFS/BFS the adjacency list). Union-find starts at n and decrements on a successful merge. Isolated nodes count. n = 5, [[0,1],[1,2],[3,4]] → 2. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'tags' => ['graphs', 'union-find', 'dfs', 'step-by-step'],
    'related_guide' => 'number-of-connected-components-in-an-undirected-graph',
];
