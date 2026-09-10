<?php
declare(strict_types=1);

return [
    'title' => 'Super Ugly Number: k pointers, one per prime',
    'leetcode' => 313,
    'summary' => 'nth positive integer whose prime factors all sit in primes. Generalize Ugly Number II: dp[0]=1, one index per prime, next is the min of dp[ptr[i]] × primes[i], then advance every pointer that produced that min. 12 with [2,7,13,19] → 32. n=1 → 1.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'heap', 'math', 'leetcode'],
    'related_session' => 'super-ugly-number',
];
