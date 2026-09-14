<?php
declare(strict_types=1);

return [
    'title' => 'Nth Digit: skip whole length-k blocks',
    'leetcode' => 400,
    'difficulty' => 'Med',
    'summary' => 'The sequence 1,2,… concatenated. Return the nth digit (n up to 2³¹−1). Skip k-digit blocks: there are 9 × 10^(k−1) such numbers, so k × 9 × 10^(k−1) digits. Then pick the number and the digit inside it. n=3 → 3. n=11 → 0 (the 0 of 10). Not string-build. Watch 32-bit overflow.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'kind' => 'algo',
    'tags' => ['math', 'binary-search', 'leetcode'],
    'related_session' => 'nth-digit',
];
