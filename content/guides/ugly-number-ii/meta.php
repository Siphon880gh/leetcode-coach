<?php
declare(strict_types=1);

return [
    'title' => 'Ugly Number II: three pointers merge 2, 3, 5',
    'leetcode' => 264,
    'summary' => 'The nth ugly number (factors only 2, 3, 5). dp[0] = 1. Three indices: next candidate is min of dp[p2]×2, dp[p3]×3, dp[p5]×5. Advance every pointer that produced that min so 6 is not generated twice. 10 → 12.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'heap', 'math', 'leetcode'],
    'related_session' => 'ugly-number-ii',
];
