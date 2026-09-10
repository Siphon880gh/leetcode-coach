<?php
declare(strict_types=1);

return [
    'title' => 'Best Meeting Point: median row and median column',
    'leetcode' => 296,
    'summary' => 'Walk a deterministic path: Manhattan distance splits into rows plus columns. Collect home rows (already sorted) and home columns (sort). Meet at the median of each. Sum of absolute deviations. Not the centroid, not BFS from every cell. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'tags' => ['math', 'matrix', 'median', 'step-by-step'],
    'related_guide' => 'best-meeting-point',
];
