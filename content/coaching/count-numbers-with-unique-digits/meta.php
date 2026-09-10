<?php
declare(strict_types=1);

return [
    'title' => 'Count Numbers with Unique Digits: permutations by length',
    'leetcode' => 357,
    'summary' => 'Walk a deterministic path: count x with distinct digits in [0, 10^n). One-digit is 10; for k digits, 9×9×8×…×(11−k). n = 2 → 91. n = 0 → 1. Do not enumerate the range. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'tags' => ['math', 'combinatorics', 'digit-dp', 'step-by-step'],
    'related_guide' => 'count-numbers-with-unique-digits',
];
