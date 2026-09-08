<?php
declare(strict_types=1);

return [
    'title' => 'Shortest Palindrome: rolling hash the palindrome prefix',
    'leetcode' => 214,
    'summary' => 'Walk a deterministic path: you may only add letters in front. Find the longest prefix that is already a palindrome (rolling hash of the prefix vs its reverse). Prepend the reverse of the leftover suffix. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Strings',
    'topic' => 'LeetCode · Strings',
    'tags' => ['strings', 'hashing', 'kmp', 'step-by-step'],
    'related_guide' => 'shortest-palindrome',
];
