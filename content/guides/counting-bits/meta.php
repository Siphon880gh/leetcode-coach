<?php
declare(strict_types=1);

return [
    'title' => 'Counting Bits: reuse the count after dropping the lowest 1',
    'leetcode' => 338,
    'summary' => 'ans[i] is how many 1-bits i has, for i from 0 through n. n up to 1e5. ans[i] = ans[i AND (i−1)] + 1 (191’s trick, already-computed prefix). Twin: ans[i] = ans[i shifted right 1] + last bit. [0,1,1] for n=2. Not a built-in popcount loop.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'kind' => 'algo',
    'tags' => ['bit-manipulation', 'dynamic-programming', 'leetcode'],
    'related_session' => 'counting-bits',
];
