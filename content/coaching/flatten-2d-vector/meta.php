<?php
declare(strict_types=1);

return [
    'title' => 'Flatten 2D Vector: skip empty rows with two indices',
    'leetcode' => 251,
    'summary' => 'Walk a deterministic path: keep row i and column j. Before next or hasNext, advance while the inner list is exhausted. Empty rows are legal. Do not copy into one array. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'tags' => ['design', 'two-pointers', 'iterator', 'step-by-step'],
    'related_guide' => 'flatten-2d-vector',
];
