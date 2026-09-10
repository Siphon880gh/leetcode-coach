<?php
declare(strict_types=1);

return [
    'title' => '3Sum Smaller: sort, fix i; if sum < target add (k − j)',
    'leetcode' => 259,
    'summary' => 'Walk a deterministic path: count index triples whose values sum to less than target. Sort, fix i, two-pointer the suffix. A too-small sum means add k minus j, then move j. Too large: move k. Do not skip duplicates like 3Sum. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Two Pointers',
    'topic' => 'LeetCode · Two Pointers',
    'tags' => ['two-pointers', 'sorting', 'arrays', 'step-by-step'],
    'related_guide' => '3sum-smaller',
];
