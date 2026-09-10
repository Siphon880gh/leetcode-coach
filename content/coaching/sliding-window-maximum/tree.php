<?php
declare(strict_types=1);

/**
 * Step-by-step tree contract:
 * - start: node id
 * - nodes[id]: message, outcome (continue|wrong|success), choices[{label, next}], optional rewind_to on wrong
 */
return [
    'start' => 'start',
    'nodes' => [
        'start' => [
            'message' => "Problem: window of length k slides left to right. Report the max of each window. [1,3,-1,-3,5,3,6,7], k=3 → [3,3,5,5,6,7]. n up to 10⁵ — nested max per window times out.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'For each start, scan the k values; or Minimum Size Subarray Sum (grow/shrink a running sum)', 'next' => 'slow'],
                ['label' => 'Deque of indices, front-to-back decreasing in nums; front is the window max', 'next' => 'dq'],
            ],
        ],
        'slow' => [
            'message' => "O(n k) scans die at 10⁵. 209 tracks a sum with a variable window; here k is fixed and you need the max, not a sum. A heap of (value, index) is O(n log n); the follow-up wants better.\nHow do you stay O(n)?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Drop front if index ≤ i−k. Pop back while nums[back] ≤ nums[i]. Push i. If i ≥ k−1, emit nums[front]', 'next' => 'dq'],
                ['label' => 'Store values in the deque, not indices', 'next' => 'wrong_val'],
            ],
        ],
        'wrong_val' => [
            'message' => "You are wrong here.\nYou need the index to know when a candidate left the window. Values alone cannot tell you that.\nStep back to when you stored values.",
            'outcome' => 'wrong',
            'rewind_to' => 'slow',
            'choices' => [],
        ],
        'dq' => [
            'message' => "Equals pop from the back too (strictly decreasing). Each index is pushed and popped at most once. Do not emit until the first window is full.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,3,-1,-3,5,3,6,7], k=3 → [3,3,5,5,6,7]', 'next' => 'cpx'],
                ['label' => 'Keep an increasing deque so the front is the minimum of the window', 'next' => 'wrong_inc'],
            ],
        ],
        'wrong_inc' => [
            'message' => "You are wrong. An increasing deque answers sliding-window minimum. This problem wants the max, so the deque decreases.\nStep back to when you inverted the order.",
            'outcome' => 'wrong',
            'rewind_to' => 'dq',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) deque, O(k) space. Heap twin is O(n log n). Not nested scans, not 209, not values-only, not an increasing deque.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Decreasing index deque; not nested max, not 209, not values, not increasing', 'next' => 'success'],
                ['label' => 'Emit nums[front] on every i including i < k−1 so the answer is length n', 'next' => 'wrong_early'],
            ],
        ],
        'wrong_early' => [
            'message' => "You are wrong. The first window is not full until i is k−1. The answer has n−k+1 values, not n.\nStep back to when you emitted early.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Decreasing deque of indices: drop expired front, pop smaller backs, push i, emit nums[front] once i ≥ k−1. O(n). Not nested scans, not 209, not values-only, not increasing.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
