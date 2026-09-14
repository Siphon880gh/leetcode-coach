<?php
declare(strict_types=1);

return [
    'title' => 'UTF-8 Validation: count remaining 10xxxxxx bytes',
    'leetcode' => 393,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: each int is one byte (low 8 bits). UTF-8 chars are 1–4 bytes. Track how many continuation bytes are still due. [197,130,1] true. [235,140,4] false. Leftover count at the end is false. Not 394. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'tags' => ['bit-manipulation', 'arrays', 'step-by-step'],
    'related_guide' => 'utf-8-validation',
];
