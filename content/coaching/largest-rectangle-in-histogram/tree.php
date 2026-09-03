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
            'message' => "Problem: bars of width 1; largest rectangle area. [2,1,5,6,2,3] → 10. n up to 1e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Trap water with left/right max, or two pointers like Container With Most Water', 'next' => 'water'],
                ['label' => 'For each bar as height, nearest shorter bar on left and right; area = h * (right-left-1)', 'next' => 'mono'],
            ],
        ],
        'water' => [
            'message' => "Trapping Rain Water sums units above bars. Container With Most Water uses two ends as walls. Here a rectangle must sit under a chosen height across a contiguous span of bars.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Try every pair of indices; n is 1e5 so O(n²) is fine', 'next' => 'wrong_n2'],
                ['label' => 'Monotonic stack of increasing heights; pop when a shorter bar arrives to set right[i]', 'next' => 'mono'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong here.\nn ≤ 1e5. Nested pairs time out. One stack pass is O(n).\nStep back to when you chose a quadratic scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'water',
            'choices' => [],
        ],
        'mono' => [
            'message' => "left[i] starts at -1, right[i] at n. Stack holds indices of strictly rising bars. When heights[stk[-1]] >= h, that index’s right bound is i. After the pops, left[i] is the new top (or -1).\nWhy right-left-1?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Open interval (left, right): bars strictly between the first shorter neighbors, width right-left-1', 'next' => 'area'],
                ['label' => 'Treat it as a 2D Maximal Rectangle on a binary matrix', 'next' => 'wrong_2d'],
            ],
        ],
        'wrong_2d' => [
            'message' => "You are wrong. Maximal Rectangle is the next problem (a 2D grid). This input is a 1D height array.\nStep back to when you jumped to 2D.",
            'outcome' => 'wrong',
            'rewind_to' => 'mono',
            'choices' => [],
        ],
        'area' => [
            'message' => "Max over i of heights[i] * (right[i] - left[i] - 1). Time O(n), extra O(n). Example 1: height 5 over width 2 is 10.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'That maximum area — an integer, not trapped water units', 'next' => 'success'],
                ['label' => 'The list of bars in the rectangle, like a subset', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. The signature returns one integer area. Subsets enumerates combinations of values, not histogram geometry.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'area',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Monotonic stack: nearest shorter left and right for each bar; area h*(right-left-1). O(n). Not rain water, not container two-pointers, not Maximal Rectangle’s 2D grid. [2,1,5,6,2,3] → 10.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
