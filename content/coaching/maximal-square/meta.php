<?php
declare(strict_types=1);

return [
    'title' => 'Maximal Square: min of three neighbors plus one',
    'leetcode' => 221,
    'summary' => 'Walk a deterministic path: largest all-1s square, return its area. If the cell is 1, side length is 1 plus the min of the square ending above, left, and up-left. Square that side. Characters, not ints. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'matrix', 'step-by-step'],
    'related_guide' => 'maximal-square',
];
