<?php
declare(strict_types=1);

return [
    'title' => 'Valid Word Abbreviation: skip digits, reject leading zeros',
    'leetcode' => 408,
    'difficulty' => 'Easy',
    'summary' => 'Walk a deterministic path: two pointers on word and abbr. Digits build a skip count x (reject a leading 0). On a letter, skip x then that letter must match. Finish only if i+x equals word length and abbr is fully used. internationalization / i12iz4n → true. apple / a2e → false. Not 320. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Two Pointers',
    'topic' => 'LeetCode · Two Pointers',
    'tags' => ['two-pointers', 'strings', 'step-by-step'],
    'related_guide' => 'valid-word-abbreviation',
];
