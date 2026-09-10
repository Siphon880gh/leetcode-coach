<?php
declare(strict_types=1);

return [
    'title' => 'Valid Anagram: same letter counts',
    'leetcode' => 242,
    'summary' => 'Walk a deterministic path: unequal lengths are false; count 26 letters in s, decrement on t, reject a negative. Sort both is the same test, slower. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'tags' => ['hash-table', 'strings', 'sorting', 'step-by-step'],
    'related_guide' => 'valid-anagram',
];
