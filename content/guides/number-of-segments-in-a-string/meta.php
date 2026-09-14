<?php
declare(strict_types=1);

return [
    'title' => 'Number of Segments in a String: count non-space run starts',
    'leetcode' => 434,
    'difficulty' => 'Easy',
    'summary' => 'A segment is a contiguous run of non-space characters. Walk s and increment when the current char is not a space and the previous char is a space (or i is 0). "Hello, my name is John" → 5 (comma stays on Hello). Empty or all spaces → 0. Not Length of Last Word (58).',
    'category' => 'LeetCode',
    'subcategory' => 'Strings',
    'topic' => 'LeetCode · Strings',
    'kind' => 'algo',
    'tags' => ['strings', 'simulation', 'leetcode'],
];
