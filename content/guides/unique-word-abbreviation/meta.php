<?php
declare(strict_types=1);

return [
    'title' => 'Unique Word Abbreviation: map abbr to the set of words',
    'leetcode' => 288,
    'summary' => 'Abbr is first + (length minus 2) + last, or the word itself if length is under 3. Hash each dictionary word into a set per abbr. isUnique if that set is empty, or it holds only this word.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'kind' => 'algo',
    'tags' => ['design', 'hash-table', 'strings', 'leetcode'],
    'related_session' => 'unique-word-abbreviation',
];
