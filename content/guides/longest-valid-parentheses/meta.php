<?php
declare(strict_types=1);

return [
    'title' => 'Longest valid parentheses: stack of indices',
    'leetcode' => 32,
    'summary' => 'Keep unmatched openers (and a sentinel) as indices. Each closer pops; span is i minus the new top.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'kind' => 'algo',
    'tags' => ['stack', 'strings', 'parentheses', 'leetcode'],
    'related_session' => 'longest-valid-parentheses',
];
