<?php
declare(strict_types=1);

return [
    'title' => 'Split Array Largest Sum: binary search the cap, greedy pack',
    'leetcode' => 410,
    'difficulty' => 'Hard',
    'summary' => 'Walk a deterministic path: split nums into k contiguous pieces; minimize the largest piece sum. Binary search that cap: left is max(nums), right is the total. Greedy: start a new piece when adding x would exceed mid. [7,2,5,10,8] k=2 → 18. Not Kadane (53). Same pattern as 1011. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Search',
    'topic' => 'LeetCode · Binary Search',
    'tags' => ['binary-search', 'greedy', 'arrays', 'step-by-step'],
    'related_guide' => 'split-array-largest-sum',
];
