<?php
declare(strict_types=1);

return [
    'title' => 'Rotate Function: next F from last F plus sum minus n times the new head',
    'leetcode' => 396,
    'difficulty' => 'Med',
    'summary' => 'F(k) is the weighted sum 0×arr[0] + 1×arr[1] + … + (n−1)×arr[n−1] after a clockwise rotate by k. Next F = last F + sum(nums) − n × (value that just became index 0). [4,3,2,6] → 26. [100] → 0. Do not recompute each F in O(n). Not 189.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'kind' => 'algo',
    'tags' => ['math', 'arrays', 'dynamic-programming', 'leetcode'],
];
