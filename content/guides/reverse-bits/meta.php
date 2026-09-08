<?php
declare(strict_types=1);

return [
    'title' => 'Reverse Bits: peel the low bit, park it at 31−i',
    'leetcode' => 190,
    'summary' => 'Treat n as 32 bits. For i from 0 to 31, OR n AND 1 into bit 31−i of ans, then shift n right. Always 32 steps so leading zeros become trailing zeros.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'kind' => 'algo',
    'tags' => ['bit-manipulation', 'unsigned', 'leetcode'],
    'related_session' => 'reverse-bits',
];
