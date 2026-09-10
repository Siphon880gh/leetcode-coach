<?php
declare(strict_types=1);

return [
    'title' => 'Different Ways to Add Parentheses: split at each operator',
    'leetcode' => 241,
    'summary' => 'Walk a deterministic path: every parenthesization is a split at some operator. Memoize each substring: if it is all digits, one number; else combine every left result with every right result using that operator. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Divide and Conquer',
    'topic' => 'LeetCode · Divide and Conquer',
    'tags' => ['divide-and-conquer', 'memoization', 'recursion', 'step-by-step'],
    'related_guide' => 'different-ways-to-add-parentheses',
];
