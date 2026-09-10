<?php
declare(strict_types=1);

return [
    'title' => 'Encode and Decode Strings: length prefix, then the payload',
    'leetcode' => 271,
    'summary' => 'Walk a deterministic path: encode each string as a fixed-width length then the bytes. Decode by reading the length, then that many characters. Do not join on a delimiter that can appear in the data. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'tags' => ['design', 'strings', 'encoding', 'step-by-step'],
    'related_guide' => 'encode-and-decode-strings',
];
