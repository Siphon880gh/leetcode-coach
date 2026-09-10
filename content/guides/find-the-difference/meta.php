<?php
declare(strict_types=1);

return [
    'title' => 'Find the Difference: the extra letter in t',
    'leetcode' => 389,
    'summary' => 't is s shuffled plus one extra letter. Return that letter. Count s, decrement on t; first negative count is the extra. XOR all of s and t, or sum of code points. abcd / abcde → e. empty / y → y. Not 387 (first unique in one string). Not 136 (XOR of ints).',
    'category' => 'LeetCode',
    'subcategory' => 'Counting',
    'topic' => 'LeetCode · Counting',
    'kind' => 'algo',
    'tags' => ['counting', 'bit-manipulation', 'strings', 'leetcode'],
];
