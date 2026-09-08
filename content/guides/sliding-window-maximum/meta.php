<?php
declare(strict_types=1);

return [
    'title' => 'Sliding Window Maximum: monotonic deque of decreasing indices',
    'leetcode' => 239,
    'summary' => 'Window of length k slides right. Store indices in a deque that is strictly decreasing in value. Drop the front when it leaves the window. After each index i ≥ k−1, nums at the front is the max.',
    'category' => 'LeetCode',
    'subcategory' => 'Sliding Window',
    'topic' => 'LeetCode · Sliding Window',
    'kind' => 'algo',
    'tags' => ['sliding-window', 'monotonic-queue', 'deque', 'heap', 'leetcode'],
];
