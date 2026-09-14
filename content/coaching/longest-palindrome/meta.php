<?php
declare(strict_types=1);

return [
    'title' => 'Longest Palindrome: even pairs plus at most one center',
    'leetcode' => 409,
    'difficulty' => 'Easy',
    'summary' => 'Walk a deterministic path: count letters (case-sensitive). Use the even part of every count. If any letter is leftover, add 1 for the middle. abccccdd → 7. a → 1. Not a contiguous substring (5). Not Valid Palindrome. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Counting',
    'topic' => 'LeetCode · Counting',
    'tags' => ['counting', 'greedy', 'hash-table', 'strings', 'step-by-step'],
    'related_guide' => 'longest-palindrome',
];
