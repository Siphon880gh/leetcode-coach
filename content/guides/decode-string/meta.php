<?php
declare(strict_types=1);

return [
    'title' => 'Decode String: two stacks for k[chunk]',
    'leetcode' => 394,
    'difficulty' => 'Med',
    'summary' => 'k[chunk] means repeat chunk k times, and brackets nest. Digit stack plus string stack: on [, push the count and the prefix so far; on ], pop and append the inner piece repeated k times. 3[a]2[bc] → aaabcbc. 3[a2[c]] → accaccacc. Not 393 (UTF-8). Not a calculator.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'kind' => 'algo',
    'tags' => ['stack', 'strings', 'recursion', 'leetcode'],
    'related_session' => 'decode-string',
];
