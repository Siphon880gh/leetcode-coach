<?php
declare(strict_types=1);

return [
    'title' => 'Sliding Window Maximum: monotonic deque of decreasing indices',
    'leetcode' => 239,
    'summary' => 'Walk a deterministic path: window of length k slides right. Store indices in a deque that is strictly decreasing in value. Drop the front when it leaves the window. After each index i ≥ k−1, nums at the front is the max. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Sliding Window',
    'topic' => 'LeetCode · Sliding Window',
    'tags' => ['sliding-window', 'monotonic-queue', 'deque', 'step-by-step'],
    'related_guide' => 'sliding-window-maximum',
];
