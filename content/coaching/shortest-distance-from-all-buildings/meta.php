<?php
declare(strict_types=1);

return [
    'title' => 'Shortest Distance from All Buildings: BFS from each building',
    'leetcode' => 317,
    'summary' => 'Walk a deterministic path: 0 empty, 1 building, 2 obstacle. House must sit on a 0 and 4-walk to every 1. BFS from each building into empty cells; add distance and a hit count. Min dist among cells hit by every building, else −1. Not Manhattan (296): walls block. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'tags' => ['graphs', 'bfs', 'matrix', 'step-by-step'],
    'related_guide' => 'shortest-distance-from-all-buildings',
];
