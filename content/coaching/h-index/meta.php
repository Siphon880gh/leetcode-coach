<?php
declare(strict_types=1);

return [
    'title' => 'H-Index: at least h papers with at least h citations',
    'leetcode' => 274,
    'summary' => 'Walk a deterministic path: sort descending, then the largest h with citations[h−1] ≥ h. Counting twin: bucket min(cite, n) and scan down. Not H-Index II. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Sorting',
    'topic' => 'LeetCode · Sorting',
    'tags' => ['sorting', 'counting-sort', 'arrays', 'step-by-step'],
    'related_guide' => 'h-index',
];
