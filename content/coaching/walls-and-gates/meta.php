<?php
declare(strict_types=1);

return [
    'title' => 'Walls and Gates: multi-source BFS from every gate',
    'leetcode' => 286,
    'summary' => 'Walk a deterministic path: −1 is a wall, 0 a gate, INF an empty room. Queue every gate, then expand. The first write into INF is the nearest-gate distance. Unreachable stays INF. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'tags' => ['graphs', 'bfs', 'matrix', 'step-by-step'],
    'related_guide' => 'walls-and-gates',
];
