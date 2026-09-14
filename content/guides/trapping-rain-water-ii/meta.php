<?php
declare(strict_types=1);

return [
    'title' => 'Trapping Rain Water II: min-heap from the boundary inward',
    'leetcode' => 407,
    'difficulty' => 'Hard',
    'summary' => 'Push every border cell into a min-heap as the initial wall. Pop the lowest wall, visit unseen neighbors: water is max(0, wall − height). Re-push the neighbor with height max(wall, cell). [[1,4,3,1,3,2],[3,2,1,3,2,4],[2,3,3,2,3,1]] → 4. Not 42 (1D).',
    'category' => 'LeetCode',
    'subcategory' => 'Heap',
    'topic' => 'LeetCode · Heap',
    'kind' => 'algo',
    'tags' => ['heap', 'bfs', 'matrix', 'leetcode'],
    'related_session' => 'trapping-rain-water-ii',
];
