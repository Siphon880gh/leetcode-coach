<?php
declare(strict_types=1);

return [
    'title' => 'Number of Islands: flood each land component',
    'leetcode' => 200,
    'summary' => 'Scan the grid. Every leftover 1 starts an island: DFS or BFS four ways and paint that component to 0. Diagonals do not connect. Count the starts.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'kind' => 'algo',
    'tags' => ['graphs', 'dfs', 'bfs', 'matrix', 'leetcode'],
    'related_session' => 'number-of-islands',
];
