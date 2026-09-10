<?php
declare(strict_types=1);

return [
    'title' => 'Power of Three: divide by 3, or 3^19 modulo n',
    'leetcode' => 326,
    'summary' => 'Walk a deterministic path: true iff n equals 3^x for some integer x. Loop: while n > 2, n must be divisible by 3. Follow-up: n > 0 and the max 32-bit 3^19 (1162261467) is divisible by n. 27 true; 0 and negatives false. Not a 2-bit trick. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'tags' => ['math', 'recursion', 'step-by-step'],
    'related_guide' => 'power-of-three',
];
