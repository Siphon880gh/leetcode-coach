<?php
declare(strict_types=1);

return [
    'title' => 'Add Strings: digit-by-digit from the right with carry',
    'leetcode' => 415,
    'difficulty' => 'Easy',
    'summary' => 'Add two non-negative integers given as digit strings without parsing the whole value. Walk from the last character of each, add digits plus carry, emit the ones digit, keep carry for the next column. Reverse at the end. "11"+"123" → "134". "0"+"0" → "0". Not 2 (linked list). Not 67 (binary).',
    'category' => 'LeetCode',
    'subcategory' => 'Strings',
    'topic' => 'LeetCode · Strings',
    'kind' => 'algo',
    'tags' => ['strings', 'math', 'simulation', 'leetcode'],
    'related_session' => 'add-strings',
];
