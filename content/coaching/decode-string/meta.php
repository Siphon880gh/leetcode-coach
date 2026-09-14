<?php
declare(strict_types=1);

return [
    'title' => 'Decode String: two stacks for k[chunk]',
    'leetcode' => 394,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: k[chunk] repeats chunk k times and nests. Digit stack plus string stack: on [, push the count and the prefix so far; on ], pop and append the inner piece repeated k times. 3[a]2[bc] → aaabcbc. 3[a2[c]] → accaccacc. Not 393. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'tags' => ['stack', 'strings', 'recursion', 'step-by-step'],
    'related_guide' => 'decode-string',
];
