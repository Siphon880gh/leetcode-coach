<?php
declare(strict_types=1);

return [
    'title' => 'Super Pow: modular pow by digits, least significant first',
    'leetcode' => 372,
    'summary' => 'Walk a deterministic path: a^b mod 1337, b as a digit array. From the last digit: multiply ans by a^d mod 1337, then a becomes a^10 mod 1337. Binary exponentiation for each small power. 2^[3] → 8. Not 50. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'tags' => ['math', 'modular-exponentiation', 'step-by-step'],
    'related_guide' => 'super-pow',
];
