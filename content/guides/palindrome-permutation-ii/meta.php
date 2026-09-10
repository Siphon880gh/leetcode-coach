<?php
declare(strict_types=1);

return [
    'title' => 'Palindrome Permutation II: wrap pairs around the center',
    'leetcode' => 267,
    'summary' => 'All palindromic permutations, no duplicates. If two letters are odd, return empty. Seed dfs with the one odd letter (or empty). Repeatedly wrap a letter with remaining count at least 2: c + t + c. "aabb" → abba, baab.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'kind' => 'algo',
    'tags' => ['backtracking', 'hash-table', 'strings', 'leetcode'],
    'related_session' => 'palindrome-permutation-ii',
];
