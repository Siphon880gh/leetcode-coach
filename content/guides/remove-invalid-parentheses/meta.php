<?php
declare(strict_types=1);

return [
    'title' => 'Remove Invalid Parentheses: count extras, then skip-or-keep DFS',
    'leetcode' => 301,
    'summary' => 'Return every unique string after deleting the fewest invalid parentheses. Count leftover ( and unmatched ). DFS each index: skip if a budget remains, or keep; prune invalid prefixes. Letters stay.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'kind' => 'algo',
    'tags' => ['backtracking', 'dfs', 'parentheses', 'leetcode'],
    'related_session' => 'remove-invalid-parentheses',
];
