<?php
declare(strict_types=1);

return [
    'title' => 'UTF-8 Validation: count remaining 10xxxxxx bytes',
    'leetcode' => 393,
    'summary' => 'Each int is one byte (low 8 bits). UTF-8 chars are 1–4 bytes: 0xxxxxxx, 110xxxxx 10xxxxxx, 1110xxxx plus two 10s, 11110xxx plus three 10s. Track how many continuation bytes are still due. [197,130,1] true. [235,140,4] false. Leftover count at the end is false. Not 394.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'kind' => 'algo',
    'tags' => ['bit-manipulation', 'arrays', 'leetcode'],
];
