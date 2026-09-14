<?php
declare(strict_types=1);

return [
    'title' => 'Strong Password Checker: length cases, spend deletes on aaa runs first',
    'leetcode' => 420,
    'difficulty' => 'Hard',
    'summary' => 'Min inserts, deletes, and replaces to hit length 6..20, one lower, one upper, one digit, and no three identical in a row. n<6: max(6−n, missing types). 6..20: max(run replacements, missing types). n>20: must delete n−20; spend those deletes on aaa runs (mod 3) before replacing. "a" → 5. "aA1" → 3. "1337C0d3" → 0. Not 2299 (check only).',
    'category' => 'LeetCode',
    'subcategory' => 'Greedy',
    'topic' => 'LeetCode · Greedy',
    'kind' => 'algo',
    'tags' => ['greedy', 'strings', 'heap', 'leetcode'],
];
