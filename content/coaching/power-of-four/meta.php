<?php
declare(strict_types=1);

return [
    'title' => 'Power of Four: one 1-bit, and it sits on an even index',
    'leetcode' => 342,
    'summary' => 'Walk a deterministic path: n is 4 to some integer power. n > 0, a single 1-bit (231: n AND n−1 is 0), and that bit is on an even position so n AND 0xAAAAAAAA is 0. 16 and 1 are true; 5 and 8 are false. No divide-by-4 loop. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'tags' => ['bit-manipulation', 'math', 'step-by-step'],
    'related_guide' => 'power-of-four',
];
