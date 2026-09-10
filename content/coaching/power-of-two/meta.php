<?php
declare(strict_types=1);

return [
    'title' => 'Power of Two: n > 0 and n AND (n minus 1) is 0',
    'leetcode' => 231,
    'summary' => 'Walk a deterministic path: a power of two has exactly one 1-bit. Reject n ≤ 0. Then n AND (n minus 1) clears that bit and must be 0. 1 is 2⁰, 16 is true, 3 is false. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'tags' => ['bit-manipulation', 'math', 'step-by-step'],
    'related_guide' => 'power-of-two',
];
