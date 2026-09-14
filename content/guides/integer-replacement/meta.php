<?php
declare(strict_types=1);

return [
    'title' => 'Integer Replacement: even halves; odd prefers clearing two 1s',
    'leetcode' => 397,
    'difficulty' => 'Med',
    'summary' => 'Min operations to turn n into 1: even → n/2; odd → n+1 or n−1. Greedy: always halve when even. When odd, increment if n is not 3 and the last two bits are 11; else decrement. 8 → 3. 7 → 4. 3 goes down, not up. n up to 2^31−1. Not Collatz (always 3n+1).',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'kind' => 'algo',
    'tags' => ['bit-manipulation', 'greedy', 'math', 'leetcode'],
    'related_session' => 'integer-replacement',
];
