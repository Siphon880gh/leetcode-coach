<?php
declare(strict_types=1);

return [
    'title' => 'Third Maximum Number: three distinct slots, skip duplicates',
    'leetcode' => 414,
    'difficulty' => 'Easy',
    'summary' => 'Return the third distinct max, or the max if fewer than three uniques. Keep m1 > m2 > m3; skip a value already in a slot; shift downward on a new larger number. [3,2,1] → 1. [1,2] → 2. [2,2,3,1] → 1. Not 215 (duplicates rank separately).',
    'category' => 'LeetCode',
    'subcategory' => 'Arrays',
    'topic' => 'LeetCode · Arrays',
    'kind' => 'algo',
    'tags' => ['arrays', 'sorting', 'leetcode'],
    'related_session' => 'third-maximum-number',
];
