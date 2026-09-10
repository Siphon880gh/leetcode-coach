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
            'message' => "Problem: longest subsequence whose successive diffs strictly alternate +/− (first step either way). One element is a wiggle; two unequal elements are a wiggle; a zero diff is not. [1,7,4,9,2,5] → 6. Rising [1,2,…,9] → 2. n up to 1000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'LIS (300) on values, or treat this as Wiggle Sort (280) and reorder in place', 'next' => 'wrong_lis'],
                ['label' => 'DP: f[i] longest ending at i with an up, g[i] ending with a down', 'next' => 'dp'],
            ],
        ],
        'wrong_lis' => [
            'message' => "You are wrong here. 300 never flips direction. 280 reorders the whole array; here you only return a length and may skip.\nStep back to when you used LIS or 280.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Both start at 1. For each i, scan earlier j. If nums[j] < nums[i], f[i] = max(f[i], g[j] + 1) — you need a down before this up. If nums[j] > nums[i], extend g[i] from f[j]. Equals do not extend. Answer is the max of all f and g.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count a plateau as a turn, or return n for a monotone run', 'next' => 'wrong_eq'],
                ['label' => 'Skip equals; a strictly rising run is length 2', 'next' => 'kind'],
            ],
        ],
        'wrong_eq' => [
            'message' => "You are wrong. A zero difference is not a wiggle. [1,2,3,4,5,6,7,8,9] is 2, not 9.\nStep back to when you counted a plateau or a monotone run as a full wiggle.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Follow-up O(n): keep scalars up and down. A rise sets up = down + 1; a fall sets down = up + 1; a plateau skips. That is greedy extrema. The writeup DP is O(n²), fine at n = 1000. This is a subsequence, not a contiguous subarray.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Up/down DP (or two counters). Not 300. Not 280', 'next' => 'success'],
                ['label' => 'Require a contiguous window, or skip the opposite-side predecessor (extend f from f)', 'next' => 'wrong_win'],
            ],
        ],
        'wrong_win' => [
            'message' => "You are wrong. You may skip. An up must follow a down ending, not another up.\nStep back to when you required a window or extended from the same side.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. f ends up from a down; g ends down from an up. [1,7,4,9,2,5] → 6. Rising run → 2. Not 280. Not 300.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
