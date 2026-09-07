<?php
declare(strict_types=1);

return [
    'title' => 'Palindrome Partitioning: every cut is a palindrome',
    'leetcode' => 131,
    'summary' => 'Precompute palindrome DP. DFS from i: take s[i..j] only if it is a palindrome, pop on the way back. Snapshot t when i hits n.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'kind' => 'algo',
    'tags' => ['backtracking', 'palindrome', 'dfs', 'leetcode'],
    'related_session' => 'palindrome-partitioning',
];
