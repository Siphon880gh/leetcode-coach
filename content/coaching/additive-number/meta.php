<?php
declare(strict_types=1);

return [
    'title' => 'Additive Number: pick first two, then sums must prefix the rest',
    'leetcode' => 306,
    'summary' => 'Walk a deterministic path: at least three numbers, no leading zeros. Choose splits for the first two addends, then each later number must equal their sum and match a prefix of the leftover digits. “112358” is true. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'tags' => ['backtracking', 'strings', 'math', 'step-by-step'],
    'related_guide' => 'additive-number',
];
