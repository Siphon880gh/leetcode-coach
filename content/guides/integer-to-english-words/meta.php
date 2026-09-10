<?php
declare(strict_types=1);

return [
    'title' => 'Integer to English Words: three-digit groups, then scale words',
    'leetcode' => 273,
    'summary' => 'Zero is a special case. Split the number into billion, million, thousand, and ones. Convert each 0–999 chunk with a helper (under 20 lookup, tens, then Hundred). Skip empty groups. Join with spaces. Not Integer to Roman.',
    'category' => 'LeetCode',
    'subcategory' => 'Recursion',
    'topic' => 'LeetCode · Recursion',
    'kind' => 'algo',
    'tags' => ['recursion', 'math', 'strings', 'leetcode'],
    'related_session' => 'integer-to-english-words',
];
