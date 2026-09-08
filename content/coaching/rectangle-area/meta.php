<?php
declare(strict_types=1);

return [
    'title' => 'Rectangle Area: both areas minus the overlap',
    'leetcode' => 223,
    'summary' => 'Walk a deterministic path: covered area of two axis-aligned rectangles is A plus B minus the overlap. Overlap width is min of right edges minus max of left edges, clamped at 0; same for height. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'tags' => ['math', 'geometry', 'step-by-step'],
    'related_guide' => 'rectangle-area',
];
