<?php
declare(strict_types=1);

return [
    'title' => 'Valid Anagram: same letter counts',
    'leetcode' => 242,
    'summary' => 'True if t is a rearrangement of s. Unequal lengths → false. Count the 26 letters in s, decrement on t, reject a negative. Sort both and compare is the same test, slower.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'kind' => 'algo',
    'tags' => ['hash-table', 'strings', 'sorting', 'leetcode'],
    'related_session' => 'valid-anagram',
];
