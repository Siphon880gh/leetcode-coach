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
            'message' => "Problem: zero array of length n (up to 1e5). Up to 1e4 updates. Each [start, end, inc] adds inc on the inclusive range [start, end]. Return the array. length 5, [[1,3,2],[2,4,3],[0,2,−2]] → [−2,0,3,5,3].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'For each update, loop i from start to end and add inc to arr[i]', 'next' => 'wrong_naive'],
                ['label' => 'Difference array: +inc at start, −inc at end+1, then prefix-sum', 'next' => 'diff'],
            ],
        ],
        'wrong_naive' => [
            'message' => "You are wrong here. n times k can hit 1e5 × 1e4 operations and will time out.\nStep back to when you walked every cell of every range.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'diff' => [
            'message' => "d starts as n zeros. For [l, r, c]: d[l] += c. If r + 1 < n, d[r + 1] −= c. Then d[i] += d[i − 1] left to right (or accumulate). That running sum is the answer. Ranges are inclusive on both ends; inc can be negative.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always write d[r + 1] even when r is n − 1, or treat the end as exclusive', 'next' => 'wrong_end'],
                ['label' => 'Guard r + 1 < n so a range that ends at the last index has no cancel slot', 'next' => 'kind'],
            ],
        ],
        'wrong_end' => [
            'message' => "You are wrong. Writing past n − 1 is out of bounds. An exclusive end would miss arr[end].\nStep back to when you skipped the guard or treated the range as half-open.",
            'outcome' => 'wrong',
            'rewind_to' => 'diff',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Range Sum Query - Mutable (307) answers live queries with a Fenwick tree. Here you apply a batch and return once — two writes per update plus one prefix pass. Corporate Flight Bookings (1109) is the same template.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Difference marks plus prefix. O(n + k). Not a per-cell loop. Not 307', 'next' => 'success'],
                ['label' => 'Build a Fenwick or segment tree because every range update needs a tree', 'next' => 'wrong_bit'],
            ],
        ],
        'wrong_bit' => [
            'message' => "You are wrong. A tree is for mixed updates and queries. This problem never queries in the middle.\nStep back to when you required a Fenwick or segment tree.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. +inc at start, −inc at end+1 (if in range), then prefix. length 5 → [−2,0,3,5,3]. Not a nested loop. Not 307.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
