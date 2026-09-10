<?php
declare(strict_types=1);

return [
    'title' => 'Shortest Word Distance: last index of each word',
    'leetcode' => 243,
    'summary' => 'Walk a deterministic path: one scan, remember the latest index of each distinct word, update min abs(i − j) once both have been seen. Nested pairs are too slow. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Arrays',
    'topic' => 'LeetCode · Arrays',
    'tags' => ['arrays', 'two-pointers', 'strings', 'step-by-step'],
    'related_guide' => 'shortest-word-distance',
];
