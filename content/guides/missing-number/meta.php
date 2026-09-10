<?php
declare(strict_types=1);

return [
    'title' => 'Missing Number: XOR 0..n with the array',
    'leetcode' => 268,
    'summary' => 'n distinct values from 0..n, one missing. XOR every index i with nums[i], start from n. Pairs cancel; the leftover is the missing number. Gauss sum n(n+1)/2 minus the array sum is the same answer.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'kind' => 'algo',
    'tags' => ['bit-manipulation', 'xor', 'math', 'leetcode'],
    'related_session' => 'missing-number',
];
