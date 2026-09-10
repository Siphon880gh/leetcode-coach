<?php
declare(strict_types=1);

return [
    'title' => 'Remove Invalid Parentheses: count extras, then skip-or-keep DFS',
    'leetcode' => 301,
    'summary' => 'Walk a deterministic path: count leftover ( and unmatched ). DFS each index: skip if a budget remains, or keep; prune invalid prefixes. Letters stay. "()())()" yields two minima. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'tags' => ['backtracking', 'dfs', 'parentheses', 'step-by-step'],
    'related_guide' => 'remove-invalid-parentheses',
];
