<?php
declare(strict_types=1);

return [
    'title' => 'Count of Smaller Numbers After Self: Fenwick from the right',
    'leetcode' => 315,
    'summary' => 'Walk a deterministic path: counts[i] is how many nums[j] < nums[i] with j > i. Rank-compress, walk right to left, Fenwick frequencies: query(rank minus 1) then insert 1 at rank. [5,2,6,1] → [2,1,1,0]. n up to 1e5; not a nested scan. Merge-sort counting is the twin. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Indexed Tree',
    'topic' => 'LeetCode · Binary Indexed Tree',
    'tags' => ['fenwick', 'merge-sort', 'divide-and-conquer', 'step-by-step'],
    'related_guide' => 'count-of-smaller-numbers-after-self',
];
