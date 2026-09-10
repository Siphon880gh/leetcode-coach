<?php
declare(strict_types=1);

return [
    'title' => 'Add Digits: digital root is (num − 1) mod 9, plus 1',
    'leetcode' => 258,
    'summary' => 'Walk a deterministic path: keep summing digits until one digit remains. That is the digital root: 0 when num is 0, otherwise (num − 1) mod 9 plus 1. Not Happy Number squares. 9 maps to 9, not 0. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'tags' => ['math', 'digital-root', 'step-by-step'],
    'related_guide' => 'add-digits',
];
