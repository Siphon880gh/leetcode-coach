<?php
declare(strict_types=1);

return [
    'title' => 'Convert a Number to Hexadecimal: eight nibbles, skip leading zeros',
    'leetcode' => 405,
    'difficulty' => 'Easy',
    'summary' => 'Treat num as 32-bit two’s complement. Walk eight 4-bit groups from high to low; map 0–15 to 0123456789abcdef. Skip leading zeros; 0 → 0. 26 → 1a. −1 → ffffffff. Not hex() / format. Not a minus-sign string.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'kind' => 'algo',
    'tags' => ['bit-manipulation', 'math', 'strings', 'leetcode'],
];
