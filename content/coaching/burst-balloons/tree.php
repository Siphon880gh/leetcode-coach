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
            'message' => "Problem: n balloons, values nums[i]. Burst all. Bursting i scores nums[i−1] times nums[i] times nums[i+1]; missing neighbors count as 1. Maximize coins. [3,1,5,8] → 167. [1,5] → 10. n up to 300.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Greedy: always burst the smallest remaining balloon first', 'next' => 'wrong_greedy'],
                ['label' => 'Interval DP: enumerate the last balloon left in an open interval', 'next' => 'dp'],
            ],
        ],
        'wrong_greedy' => [
            'message' => "You are wrong here.\nOrder changes which neighbors are still alive. Bursting small first is not optimal.\nStep back to when you greedied the smallest.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Pad arr = [1] + nums + [1]. f[i][j] is max coins bursting strictly between i and j (endpoints stay). If k is last in (i, j), add f[i][k] + f[k][j] + arr[i] times arr[k] times arr[j]. Fill by increasing gap. Answer f[0][n+1].\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Score k as if it were first (neighbors are original adjacent nums)', 'next' => 'wrong_first'],
                ['label' => 'O(n cubed) time, O(n squared) table. Pads stay', 'next' => 'cpx'],
            ],
        ],
        'wrong_first' => [
            'message' => "You are wrong. Last burst still sees the endpoints i and j, not the original neighbors.\nStep back to when you scored k as first.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Zeros still occupy a slot. Same fill order as matrix-chain / unique BSTs.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Last balloon in (i, j). Not greedy smallest-first', 'next' => 'success'],
                ['label' => 'Skip zeros without bursting them', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. A 0 balloon still sits in the line until you burst it.\nStep back to when you skipped zeros.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Pad with 1s. Last k in (i, j) scores the two endpoints times arr[k], plus the two subintervals. [3,1,5,8] is 167. Not greedy smallest-first.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
