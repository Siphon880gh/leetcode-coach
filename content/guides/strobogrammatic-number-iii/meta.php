<?php
declare(strict_types=1);

return [
    'title' => 'Strobogrammatic Number III: generate each length, count those in [low, high]',
    'leetcode' => 248,
    'summary' => 'How many upside-down numbers sit between two digit strings. Reuse the length-n wrap from II for every n from len(low) to len(high), then keep a candidate only if it is numerically inside the closed range.',
    'category' => 'LeetCode',
    'subcategory' => 'Recursion',
    'topic' => 'LeetCode · Recursion',
    'kind' => 'algo',
    'tags' => ['recursion', 'strings', 'math', 'leetcode'],
    'related_session' => 'strobogrammatic-number-iii',
];
