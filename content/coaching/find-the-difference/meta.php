<?php
declare(strict_types=1);

return [
    'title' => 'Find the Difference: the extra letter in t',
    'leetcode' => 389,
    'difficulty' => 'Easy',
    'summary' => 'Walk a deterministic path: t is s shuffled plus one extra letter. Return that letter. Count s, decrement on t; first negative count is the extra. XOR all of s and t, or sum of code points. abcd / abcde → e. empty / y → y. Not 387. Not 136. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Counting',
    'topic' => 'LeetCode · Counting',
    'tags' => ['counting', 'bit-manipulation', 'strings', 'step-by-step'],
    'related_guide' => 'find-the-difference',
];
