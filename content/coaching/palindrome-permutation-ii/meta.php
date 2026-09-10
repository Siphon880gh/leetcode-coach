<?php
declare(strict_types=1);

return [
    'title' => 'Palindrome Permutation II: wrap pairs around the center',
    'leetcode' => 267,
    'summary' => 'Walk a deterministic path: two odds → empty list; seed dfs with the one odd letter (or empty); wrap c + t + c while a letter still has at least 2 left. "aabb" → abba, baab. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'tags' => ['backtracking', 'hash-table', 'strings', 'step-by-step'],
    'related_guide' => 'palindrome-permutation-ii',
];
