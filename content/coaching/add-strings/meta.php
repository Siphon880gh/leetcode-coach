<?php
declare(strict_types=1);

return [
    'title' => 'Add Strings: digit-by-digit from the right with carry',
    'leetcode' => 415,
    'difficulty' => 'Easy',
    'summary' => 'Walk a deterministic path: add two non-negative digit strings without parsing the whole value. Walk from the last character of each, add digits plus carry, emit the ones digit, keep carry for the next column. Reverse at the end. "11"+"123" → "134". Not 2 / 67. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Strings',
    'topic' => 'LeetCode · Strings',
    'tags' => ['strings', 'math', 'simulation', 'step-by-step'],
    'related_guide' => 'add-strings',
];
