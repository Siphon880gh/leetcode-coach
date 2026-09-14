<?php
declare(strict_types=1);

return [
    'title' => 'Nth Digit: skip whole length-k blocks',
    'leetcode' => 400,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: the sequence 1,2,… concatenated. Return the nth digit (n up to 2³¹−1). Skip k-digit blocks: 9 × 10^(k−1) numbers, so k × 9 × 10^(k−1) digits. Then pick the number and the digit inside it. n=3 → 3. n=11 → 0. Not string-build. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'tags' => ['math', 'binary-search', 'step-by-step'],
    'related_guide' => 'nth-digit',
];
