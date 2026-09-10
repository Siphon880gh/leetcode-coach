<?php
declare(strict_types=1);

return [
    'title' => 'Is Subsequence: two pointers on s and t',
    'leetcode' => 392,
    'summary' => 'True iff s is formed from t by deleting some characters (order kept). Walk t; advance in s only on a match. Done when the s pointer reaches len(s). abc / ahbgdc → true. axc / ahbgdc → false. Empty s is true. Not a substring. Not LCS (1143).',
    'category' => 'LeetCode',
    'subcategory' => 'Two Pointers',
    'topic' => 'LeetCode · Two Pointers',
    'kind' => 'algo',
    'tags' => ['two-pointers', 'strings', 'leetcode'],
];
