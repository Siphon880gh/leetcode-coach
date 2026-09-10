<?php
declare(strict_types=1);

return [
    'title' => 'Word Pattern: bijection from letters to words',
    'leetcode' => 290,
    'summary' => 'Walk a deterministic path: split s on spaces. Lengths must match the pattern. Two maps: letter → word and word → letter. Fail if either direction disagrees. abba / dog cat cat dog is true; aaaa with two different words is not. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'tags' => ['hash-table', 'strings', 'step-by-step'],
    'related_guide' => 'word-pattern',
];
