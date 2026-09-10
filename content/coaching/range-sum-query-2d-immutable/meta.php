<?php
declare(strict_types=1);

return [
    'title' => 'Range Sum Query 2D - Immutable: pad prefix, include-exclude',
    'leetcode' => 304,
    'summary' => 'Walk a deterministic path: matrix never changes. s[i+1][j+1] is the sum from (0,0) to (i,j). Query is big rectangle minus the strip above and the strip left, plus the corner subtracted twice. O(1) per call. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Prefix Sum',
    'topic' => 'LeetCode · Prefix Sum',
    'tags' => ['prefix-sum', 'matrix', 'design', 'step-by-step'],
    'related_guide' => 'range-sum-query-2d-immutable',
];
