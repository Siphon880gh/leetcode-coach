<?php
declare(strict_types=1);

return [
    'title' => 'Insert Delete GetRandom O(1): array plus index map',
    'leetcode' => 380,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: list of values plus map value → index. Insert appends. Remove swaps the hole with the last element, fixes that last index, then pops. Uniform pick from the list. Not a set-only. Not 381. Not 379. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'tags' => ['design', 'hash-map', 'array', 'randomized', 'step-by-step'],
    'related_guide' => 'insert-delete-getrandom-o1',
];
