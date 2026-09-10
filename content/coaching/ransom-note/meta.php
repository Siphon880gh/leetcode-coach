<?php
declare(strict_types=1);

return [
    'title' => 'Ransom Note: magazine counts must cover the note',
    'leetcode' => 383,
    'difficulty' => 'Easy',
    'summary' => 'Walk a deterministic path: count magazine, then decrement while scanning ransomNote; any count that goes negative is false. a vs b → false; aa vs ab → false; aa vs aab → true. Not Valid Anagram. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Counting',
    'topic' => 'LeetCode · Counting',
    'tags' => ['counting', 'hash-table', 'strings', 'step-by-step'],
    'related_guide' => 'ransom-note',
];
