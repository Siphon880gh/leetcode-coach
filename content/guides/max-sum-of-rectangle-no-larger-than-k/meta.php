<?php
declare(strict_types=1);

return [
    'title' => 'Max Sum of Rectangle No Larger Than K: row pairs, then prefix ceiling',
    'leetcode' => 363,
    'summary' => 'Max rectangle sum that is still ≤ k (a valid rectangle is guaranteed). Fix top and bottom rows, compress each column into a 1D array, then max subarray sum ≤ k via prefix sums: for running s, ceiling of s−k in an ordered set of earlier prefixes (seed 0). [[1,0,1],[0,-2,3]], k=2 → 2. If rows dwarf columns, swap the axes. Not Kadane alone, not every 4-bound brute.',
    'category' => 'LeetCode',
    'subcategory' => 'Prefix Sum',
    'topic' => 'LeetCode · Prefix Sum',
    'kind' => 'algo',
    'tags' => ['prefix-sum', 'ordered-set', 'matrix', 'binary-search', 'leetcode'],
    'related_session' => 'max-sum-of-rectangle-no-larger-than-k',
];
