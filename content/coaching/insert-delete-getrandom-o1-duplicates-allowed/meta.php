<?php
declare(strict_types=1);

return [
    'title' => 'Insert Delete GetRandom O(1) with duplicates: list plus index sets',
    'leetcode' => 381,
    'difficulty' => 'Hard',
    'summary' => 'Walk a deterministic path: multiset. insert always appends; true iff first copy. Map each value to a set of list indices. remove swaps last into one hole, then fix that last value’s index set (same-value alias). getRandom is uniform over the list. Not 380. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'tags' => ['design', 'hash-map', 'array', 'randomized', 'multiset', 'step-by-step'],
    'related_guide' => 'insert-delete-getrandom-o1-duplicates-allowed',
];
