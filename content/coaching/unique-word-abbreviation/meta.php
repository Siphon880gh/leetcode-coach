<?php
declare(strict_types=1);

return [
    'title' => 'Unique Word Abbreviation: map abbr to the set of words',
    'leetcode' => 288,
    'summary' => 'Walk a deterministic path: abbr is first + (length minus 2) + last, or the word if length is under 3. Hash each dictionary word into a set per abbr. isUnique if that set is empty, or it holds only this word. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'tags' => ['design', 'hash-table', 'strings', 'step-by-step'],
    'related_guide' => 'unique-word-abbreviation',
];
