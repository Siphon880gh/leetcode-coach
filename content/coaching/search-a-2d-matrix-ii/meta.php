<?php
declare(strict_types=1);

return [
    'title' => 'Search a 2D Matrix II: staircase from a corner',
    'leetcode' => 240,
    'summary' => 'Walk a deterministic path: rows sorted left to right, columns top to bottom, but the grid is not one flattened stream. Start at bottom-left (or top-right). Equal → true. Too big → move up. Too small → move right. O(m + n). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Matrix',
    'topic' => 'LeetCode · Matrix',
    'tags' => ['matrix', 'binary-search', 'two-pointers', 'step-by-step'],
    'related_guide' => 'search-a-2d-matrix-ii',
];
