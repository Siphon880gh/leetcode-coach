<?php
declare(strict_types=1);

return [
    'title' => 'Largest Divisible Subset: sort, then LIS-style chains',
    'leetcode' => 368,
    'summary' => 'Distinct positives. Largest subset where every pair one divides the other. Sort, then f[i] is the longest chain ending at nums[i]: extend j when nums[i] mod nums[j] is 0. Reconstruct from the best i. [1,2,3] → [1,2] or [1,3]. Not 300 (order, not divisibility).',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'sorting', 'math', 'leetcode'],
    'related_session' => 'largest-divisible-subset',
];
