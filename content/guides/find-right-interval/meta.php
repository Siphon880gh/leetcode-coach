<?php
declare(strict_types=1);

return [
    'title' => 'Find Right Interval: binary search the smallest start at or after end',
    'leetcode' => 436,
    'difficulty' => 'Med',
    'summary' => 'Starts are unique. For each interval i, the right interval is the j with smallest start_j >= end_i (j may equal i). Sort (start, original index), then bisect for the first start at or after that end. None → -1. [[3,4],[2,3],[1,2]] → [-1,0,1]. Not Merge Intervals (56).',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Search',
    'topic' => 'LeetCode · Binary Search',
    'kind' => 'algo',
    'tags' => ['binary-search', 'sorting', 'intervals', 'leetcode'],
];
