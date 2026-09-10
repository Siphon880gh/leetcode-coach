<?php
declare(strict_types=1);

return [
    'title' => 'Generalized Abbreviation: keep or count runs, never adjacent numbers',
    'leetcode' => 320,
    'summary' => 'All abbreviations of a word: replace non-overlapping, non-adjacent substrings with their lengths. Enumerate a bit mask: 1 means abbreviate, 0 means keep; flush the run length when you keep a letter. “word” has 16 forms. “23” is invalid.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'kind' => 'algo',
    'tags' => ['bit-manipulation', 'backtracking', 'strings', 'leetcode'],
    'related_session' => 'generalized-abbreviation',
];
