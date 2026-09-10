<?php
declare(strict_types=1);

return [
    'title' => 'Word Pattern II: bind letters to splits of s',
    'leetcode' => 291,
    'summary' => 's has no spaces. DFS: at pattern[i] and s[j], try every non-empty cut. Reuse a bound word, or bind a fresh letter to an unused substring, then backtrack. abab / redblueredblue is true; aabb / xyzabcxzyabc is not.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'kind' => 'algo',
    'tags' => ['backtracking', 'hash-table', 'strings', 'leetcode'],
    'related_session' => 'word-pattern-ii',
];
