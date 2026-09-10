<?php
declare(strict_types=1);

return [
    'title' => 'Nim Game: you win unless n is a multiple of 4',
    'leetcode' => 292,
    'summary' => 'Walk a deterministic path: take 1..3 stones, last stone wins, you start. Multiples of 4 are losing: whatever you take, the opponent can restore a multiple of 4. n = 4 is false; 1 and 2 are true. Return n modulo 4 is not 0. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'tags' => ['math', 'game-theory', 'brainteaser', 'step-by-step'],
    'related_guide' => 'nim-game',
];
