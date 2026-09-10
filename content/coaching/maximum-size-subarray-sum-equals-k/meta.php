<?php
declare(strict_types=1);

return [
    'title' => 'Maximum Size Subarray Sum Equals k: first prefix of s minus k',
    'leetcode' => 325,
    'summary' => 'Walk a deterministic path: longest contiguous subarray summing to k (0 if none). Prefix s; map stores the first index of each prefix (d[0]=−1). When s−k was seen, length is i minus that index. Negatives block a two-pointer window. [1,−1,5,−2,3], k=3 → 4. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Prefix Sum',
    'topic' => 'LeetCode · Prefix Sum',
    'tags' => ['prefix-sum', 'hash-table', 'arrays', 'step-by-step'],
    'related_guide' => 'maximum-size-subarray-sum-equals-k',
];
