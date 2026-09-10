<?php
declare(strict_types=1);

return [
    'title' => 'Palindrome Pairs: reverse map and a palindrome leftover',
    'leetcode' => 336,
    'summary' => 'Unique words. (i, j) iff i ≠ j and words[i] plus words[j] is a palindrome. Hash each word to its index. For every cut of w, if the suffix is a palindrome look up reverse(prefix) on the right; if the prefix is a palindrome look up reverse(suffix) on the left. Skip the empty-prefix branch so reverse-of-whole pairs are not listed twice. ["abcd","dcba","lls","s","sssll"] → [[0,1],[1,0],[3,2],[2,4]]. Not every pair concatenated.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'kind' => 'algo',
    'tags' => ['hash-table', 'trie', 'strings', 'leetcode'],
    'related_session' => 'palindrome-pairs',
];
