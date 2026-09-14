<?php
declare(strict_types=1);

return [
    'title' => 'Reconstruct Original Digits from English: unique letters first',
    'leetcode' => 423,
    'difficulty' => 'Med',
    'summary' => 's is a shuffled bag of English digit words 0–9. Return those digits in ascending order. Count unique letters first: z→0, w→2, u→4, x→6, g→8. Then h, f, s give 3, 5, 7 after subtracting the evens. Then o and i give 1 and 9. "owoztneoer" → "012". "fviefuro" → "45". Not 273.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'kind' => 'algo',
    'tags' => ['hash-table', 'math', 'strings', 'leetcode'],
];
