<?php
declare(strict_types=1);

return [
    'title' => 'Insert Delete GetRandom O(1): array plus index map',
    'leetcode' => 380,
    'summary' => 'RandomizedSet: insert / remove / getRandom each average O(1). Keep a list of values and a map value → index. Insert appends. Remove swaps the hole with the last element, fixes that last element’s index, then pops. Uniform pick from the list. Duplicates are problem 381.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'kind' => 'algo',
    'tags' => ['design', 'hash-map', 'array', 'randomized', 'leetcode'],
    'related_session' => 'insert-delete-getrandom-o1',
];
