<?php
declare(strict_types=1);

return [
    'title' => 'Integer Replacement: even halves; odd prefers clearing two 1s',
    'leetcode' => 397,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: min operations to turn n into 1. Even → n/2. Odd → n+1 or n−1. Always halve when even. When odd, increment if n is not 3 and the last two bits are 11; else decrement. 8 → 3. 7 → 4. Not Collatz. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'tags' => ['bit-manipulation', 'greedy', 'math', 'step-by-step'],
    'related_guide' => 'integer-replacement',
];
