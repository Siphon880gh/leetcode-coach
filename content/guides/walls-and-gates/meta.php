<?php
declare(strict_types=1);

return [
    'title' => 'Walls and Gates: multi-source BFS from every gate',
    'leetcode' => 286,
    'summary' => '−1 is a wall, 0 a gate, INF an empty room. Queue every gate, then expand. The first time you write into INF is the nearest-gate distance. Unreachable rooms stay INF.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'kind' => 'algo',
    'tags' => ['graphs', 'bfs', 'matrix', 'leetcode'],
    'related_session' => 'walls-and-gates',
];
