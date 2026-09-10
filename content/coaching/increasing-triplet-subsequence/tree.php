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
            'message' => "Problem: true iff indices i < j < k with strictly increasing values. Not a subarray. [1,2,3,4,5] → true. [5,4,3,2,1] → false. [2,1,5,0,4,6] → true (1,4,6). n up to 5e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'LIS (300) O(n²) table, or require adjacent indices', 'next' => 'wrong_300'],
                ['label' => 'Greedy: smallest so far, then a witnessed mid, then a larger', 'next' => 'scan'],
            ],
        ],
        'wrong_300' => [
            'message' => "You are wrong here. 300 wants the full LIS length and n here is 5e5, so that DP is too slow. The triple is a subsequence, not a contiguous subarray.\nStep back to when you copied 300 or required adjacency.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'scan' => [
            'message' => "mi = smallest seen. mid = smallest value that already has a strictly smaller number before it. If num > mid, return true. If num ≤ mi, set mi = num (mid still remembers an earlier second). Else set mid = num.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat num == mid as a third, or require the current mi to sit left of mid', 'next' => 'wrong_eq'],
                ['label' => 'O(n) time, O(1) extra; mid is witnessed by some earlier smaller value', 'next' => 'cpx'],
            ],
        ],
        'wrong_eq' => [
            'message' => "You are wrong. Equals are not strictly increasing. After a reset, mi can sit to the right of mid; that is fine because mid was witnessed earlier, not by the current mi.\nStep back to when you counted equals or demanded mi left of mid.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Follow-up is O(n) time and O(1) space. The answer is a boolean, not the indices.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'mi, then a witnessed mid, then a larger. Not 300', 'next' => 'success'],
                ['label' => 'Return the triplet indices instead of true or false', 'next' => 'wrong_idx'],
            ],
        ],
        'wrong_idx' => [
            'message' => "You are wrong. The judge wants true or false, not the three positions.\nStep back to when you returned the indices.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Track mi and a witnessed mid; a later larger value is the third. Equals do not count. Not LIS-300.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
