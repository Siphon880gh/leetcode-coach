<?php
declare(strict_types=1);

return [
    'title' => 'H-Index: at least h papers with at least h citations',
    'leetcode' => 274,
    'summary' => 'Maximum h such that citations[h−1] ≥ h after sorting descending. Counting twin: bucket min(cite, n) and accumulate from n down until the running count is at least h. Not H-Index II (already sorted).',
    'category' => 'LeetCode',
    'subcategory' => 'Sorting',
    'topic' => 'LeetCode · Sorting',
    'kind' => 'algo',
    'tags' => ['sorting', 'counting-sort', 'arrays', 'leetcode'],
    'related_session' => 'h-index',
];
