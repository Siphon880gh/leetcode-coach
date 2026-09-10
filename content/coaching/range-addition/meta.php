<?php
declare(strict_types=1);

return [
    'title' => 'Range Addition: difference array, then prefix',
    'leetcode' => 370,
    'summary' => 'Walk a deterministic path: zero array of length n. Each update adds inc on an inclusive [start, end]. Write +inc at start and −inc at end+1, then prefix-sum. length 5 → [−2,0,3,5,3]. Do not loop every cell. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Prefix Sum',
    'topic' => 'LeetCode · Prefix Sum',
    'tags' => ['prefix-sum', 'difference-array', 'arrays', 'step-by-step'],
    'related_guide' => 'range-addition',
];
