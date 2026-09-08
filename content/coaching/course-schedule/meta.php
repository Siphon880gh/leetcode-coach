<?php
declare(strict_types=1);

return [
    'title' => 'Course Schedule: Kahn, no leftover nodes',
    'leetcode' => 207,
    'summary' => 'Walk a deterministic path: queue in-degree 0, peel edges, enqueue when a degree hits 0. If every course is taken, there is no cycle. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'tags' => ['graphs', 'topological-sort', 'bfs', 'step-by-step'],
    'related_guide' => 'course-schedule',
];
