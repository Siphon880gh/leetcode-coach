<?php
declare(strict_types=1);

return [
    'title' => 'Group Shifted Strings: rotate so the first letter is a',
    'leetcode' => 249,
    'summary' => 'Walk a deterministic path: subtract the first letter so it becomes a; if a char drops below a, add 26. Same key means the same wrap-around Caesar family. Do not sort letters like Group Anagrams. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'tags' => ['hash-table', 'strings', 'step-by-step'],
    'related_guide' => 'group-shifted-strings',
];
