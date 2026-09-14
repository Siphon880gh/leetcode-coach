<?php
declare(strict_types=1);

return [
    'title' => 'Minimum Unique Word Abbreviation: keep bits that hit every diff mask',
    'leetcode' => 411,
    'difficulty' => 'Hard',
    'summary' => 'Shortest abbreviation of target that is not an abbreviation of any dictionary word. Same-length dict words become bitmasks of positions that differ. A keep-mask is unique when it hits every diff mask. Minimize letters plus number-runs. apple / [blade] → a4. Not 408 / 320 / 288.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'kind' => 'algo',
    'tags' => ['bit-manipulation', 'backtracking', 'strings', 'leetcode'],
    'related_session' => 'minimum-unique-word-abbreviation',
];
