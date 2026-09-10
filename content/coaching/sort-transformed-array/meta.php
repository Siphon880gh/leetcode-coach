<?php
declare(strict_types=1);

return [
    'title' => 'Sort Transformed Array: two pointers on a parabola',
    'leetcode' => 360,
    'summary' => 'Walk a deterministic path: nums is sorted. Transform x to a × x² + b × x + c and return that sequence sorted. a > 0: ends are largest, fill from the back. a ≤ 0: fill from the front with the smaller end. Do not map then sort. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Two Pointers',
    'topic' => 'LeetCode · Two Pointers',
    'tags' => ['two-pointers', 'math', 'arrays', 'step-by-step'],
    'related_guide' => 'sort-transformed-array',
];
