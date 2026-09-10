<?php
declare(strict_types=1);

return [
    'title' => 'Patching Array: extend the covered prefix, double when stuck',
    'leetcode' => 330,
    'summary' => 'Sorted nums; min patches so every integer in [1, n] is a subset sum. If [1, x−1] is covered, take nums[i] when it is ≤ x, else patch x and double the reach. [1,3], n=6 → 1. Use 64-bit x. Not coin change.',
    'category' => 'LeetCode',
    'subcategory' => 'Greedy',
    'topic' => 'LeetCode · Greedy',
    'kind' => 'algo',
    'tags' => ['greedy', 'arrays', 'leetcode'],
    'related_session' => 'patching-array',
];
