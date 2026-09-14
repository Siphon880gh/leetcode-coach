<?php
declare(strict_types=1);

return [
    'title' => 'Sentence Screen Fitting: walk joined sentence, back up mid-word',
    'leetcode' => 418,
    'difficulty' => 'Med',
    'summary' => 'How many times a word list fits on a rows by cols screen. Words stay whole; one space between them. Join with a trailing space, then each row adds cols to a cursor on that repeating string. Land on a space: consume it. Land inside a word: back up to the prior space. Cursor / length is the count. ["hello","world"] 2×8 → 1. Not 68 (justify).',
    'category' => 'LeetCode',
    'subcategory' => 'Strings',
    'topic' => 'LeetCode · Strings',
    'kind' => 'algo',
    'tags' => ['strings', 'dynamic-programming', 'simulation', 'leetcode'],
];
