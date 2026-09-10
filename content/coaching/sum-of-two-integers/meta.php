<?php
declare(strict_types=1);

return [
    'title' => 'Sum of Two Integers: XOR for sum, AND-shift for carry',
    'leetcode' => 371,
    'summary' => 'Walk a deterministic path: add a and b without plus or minus. XOR is the sum with no carry; (a AND b) shifted left 1 is the carry. Repeat until carry is 0. 1+2 → 3. Python needs a 32-bit mask for negatives. Not 2. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'tags' => ['bit-manipulation', 'math', 'step-by-step'],
    'related_guide' => 'sum-of-two-integers',
];
