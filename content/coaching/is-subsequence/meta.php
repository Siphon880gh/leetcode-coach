<?php
declare(strict_types=1);

return [
    'title' => 'Is Subsequence: two pointers on s and t',
    'leetcode' => 392,
    'difficulty' => 'Easy',
    'summary' => 'Walk a deterministic path: true iff s is formed from t by deleting some characters (order kept). Walk t; advance in s only on a match. Done when the s pointer reaches len(s). abc / ahbgdc → true. axc / ahbgdc → false. Empty s is true. Not a substring. Not LCS (1143). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Two Pointers',
    'topic' => 'LeetCode · Two Pointers',
    'tags' => ['two-pointers', 'strings', 'step-by-step'],
    'related_guide' => 'is-subsequence',
];
