<?php
declare(strict_types=1);

return [
    'title' => 'Insert Delete GetRandom O(1) with duplicates: list plus index sets',
    'leetcode' => 381,
    'summary' => 'RandomizedCollection is a multiset. insert always appends; true iff this is the first copy. Map each value to a set of list indices. remove swaps last into one hole, then fix that last value’s index set (same-value alias). getRandom is uniform over the list, so two 1s and one 2 → 1 with probability 2/3. 380 is unique values only.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'kind' => 'algo',
    'tags' => ['design', 'hash-map', 'array', 'randomized', 'multiset', 'leetcode'],
    'related_session' => 'insert-delete-getrandom-o1-duplicates-allowed',
];
