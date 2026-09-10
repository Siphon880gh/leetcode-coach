<?php
declare(strict_types=1);

return [
    'title' => 'Smallest Rectangle Enclosing Black Pixels: binary search the four edges',
    'leetcode' => 302,
    'summary' => 'Walk a deterministic path: one connected blob of 1s and a seed cell. Binary-search topmost and bottommost black rows, then leftmost and rightmost black columns. Area is height times width. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Search',
    'topic' => 'LeetCode · Binary Search',
    'tags' => ['binary-search', 'matrix', 'step-by-step'],
    'related_guide' => 'smallest-rectangle-enclosing-black-pixels',
];
