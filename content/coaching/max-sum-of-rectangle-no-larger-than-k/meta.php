<?php
declare(strict_types=1);

return [
    'title' => 'Max Sum of Rectangle No Larger Than K: row pairs, then prefix ceiling',
    'leetcode' => 363,
    'summary' => 'Walk a deterministic path: max rectangle sum still ≤ k. Fix top and bottom rows, compress columns to 1D, then max subarray ≤ k via prefix ceiling of s−k in an ordered set (seed 0). [[1,0,1],[0,-2,3]], k=2 → 2. Not Kadane alone. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Prefix Sum',
    'topic' => 'LeetCode · Prefix Sum',
    'tags' => ['prefix-sum', 'ordered-set', 'matrix', 'step-by-step'],
    'related_guide' => 'max-sum-of-rectangle-no-larger-than-k',
];
