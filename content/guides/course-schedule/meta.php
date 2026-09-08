<?php
declare(strict_types=1);

return [
    'title' => 'Course Schedule: Kahn, no leftover nodes',
    'leetcode' => 207,
    'summary' => 'Edge [a, b] is b → a. Queue every course with in-degree 0, peel edges, enqueue when a degree hits 0. If every course is taken, there is no cycle.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'kind' => 'algo',
    'tags' => ['graphs', 'topological-sort', 'bfs', 'leetcode'],
    'related_session' => 'course-schedule',
];
