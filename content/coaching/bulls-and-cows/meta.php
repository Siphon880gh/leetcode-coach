<?php
declare(strict_types=1);

return [
    'title' => 'Bulls and Cows: matches in place, then leftover digit mins',
    'leetcode' => 299,
    'summary' => 'Walk a deterministic path: bulls are same digit same index. Cows are leftover mins per digit. Format xAyB. “1123” vs “0111” is 1A1B, not two cows. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'tags' => ['hash-table', 'strings', 'counting', 'step-by-step'],
    'related_guide' => 'bulls-and-cows',
];
