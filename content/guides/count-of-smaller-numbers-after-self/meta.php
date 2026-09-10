<?php
declare(strict_types=1);

return [
    'title' => 'Count of Smaller Numbers After Self: Fenwick from the right',
    'leetcode' => 315,
    'summary' => 'counts[i] is how many nums[j] < nums[i] with j > i. Walk right to left. Rank-compress, Fenwick frequencies: query(rank−1) then insert 1 at rank. [5,2,6,1] → [2,1,1,0]. n up to 10⁵; not a nested scan. Merge-sort counting is the twin.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Indexed Tree',
    'topic' => 'LeetCode · Binary Indexed Tree',
    'kind' => 'algo',
    'tags' => ['fenwick', 'merge-sort', 'divide-and-conquer', 'leetcode'],
    'related_session' => 'count-of-smaller-numbers-after-self',
];
