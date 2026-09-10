<?php
declare(strict_types=1);

return [
    'title' => 'Super Pow: modular pow by digits, least significant first',
    'leetcode' => 372,
    'summary' => 'a^b mod 1337, b as a digit array (up to 2000 digits). From the last digit: ans ×= a^d mod 1337, then a ← a^10. Binary exponentiation for each small power. 2^[3] → 8; 2^[1,0] → 1024. Not 50 (that is float x, int n).',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'kind' => 'algo',
    'tags' => ['math', 'modular-exponentiation', 'leetcode'],
    'related_session' => 'super-pow',
];
