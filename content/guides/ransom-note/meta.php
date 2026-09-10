<?php
declare(strict_types=1);

return [
    'title' => 'Ransom Note: magazine counts must cover the note',
    'leetcode' => 383,
    'summary' => 'Each magazine letter is used at most once. Count magazine, then decrement while scanning ransomNote; any count that goes negative is false. a vs b → false; aa vs ab → false; aa vs aab → true. Not Valid Anagram (both strings must match exactly).',
    'category' => 'LeetCode',
    'subcategory' => 'Counting',
    'topic' => 'LeetCode · Counting',
    'kind' => 'algo',
    'tags' => ['counting', 'hash-table', 'strings', 'leetcode'],
    'related_session' => 'ransom-note',
];
