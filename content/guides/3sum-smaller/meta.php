<?php
declare(strict_types=1);

return [
    'title' => '3Sum Smaller: sort, fix i; if sum < target add (k − j)',
    'leetcode' => 259,
    'summary' => 'Count index triples whose values sum to less than target. Sort, fix i, two-pointer the suffix. A too-small sum means every k′ between j and k also works — add k minus j, then move j. Too large: move k.',
    'category' => 'LeetCode',
    'subcategory' => 'Two Pointers',
    'topic' => 'LeetCode · Two Pointers',
    'kind' => 'algo',
    'tags' => ['two-pointers', 'sorting', 'arrays', 'leetcode'],
    'related_session' => '3sum-smaller',
];
