<?php
declare(strict_types=1);

return [
    'title' => 'Word Pattern II: bind letters to splits of s',
    'leetcode' => 291,
    'summary' => 'Walk a deterministic path: s has no spaces. DFS: at pattern[i] and s[j], try every non-empty cut. Reuse a bound word, or bind a fresh letter to an unused substring, then backtrack. abab / redblueredblue is true; aabb / xyzabcxzyabc is not. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'tags' => ['backtracking', 'hash-table', 'strings', 'step-by-step'],
    'related_guide' => 'word-pattern-ii',
];
