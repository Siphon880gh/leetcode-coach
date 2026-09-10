<?php
declare(strict_types=1);

return [
    'title' => 'Count Numbers with Unique Digits: permutations by length',
    'leetcode' => 357,
    'summary' => 'Count x with distinct digits in [0, 10^n). n=0 → 1. One-digit: 10. For k digits, 9×9×8×…×(11−k). n=2 → 91. n≤8 so do not enumerate the range. Digit DP with a used-digit mask is the same count via leading zeros.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'kind' => 'algo',
    'tags' => ['math', 'combinatorics', 'digit-dp', 'leetcode'],
    'related_session' => 'count-numbers-with-unique-digits',
];
