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
            'message' => "Problem: array of length n+1; ans[i] is the number of 1-bits in i. n=2 → [0,1,1]. n=5 → [0,1,1,2,1,2]. n up to 1e5. No built-in popcount.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Call popcount / 191 on every i (O(n log n) follow-up, not the linear pass)', 'next' => 'wrong_pop'],
                ['label' => 'ans[i] = ans[i AND (i−1)] + 1; fill 0 through n', 'next' => 'dp'],
            ],
        ],
        'wrong_pop' => [
            'message' => "You are wrong here. The problem forbids built-in popcount. Per-index 191 is the easy O(n log n) follow-up, not the O(n) one pass.\nStep back to when you counted bits from scratch on each i.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dp' => [
            'message' => "ans[0]=0. i AND (i−1) drops the lowest 1; that smaller value is already in the array, so add 1. Twin: ans[i] = ans[i shifted right 1] + last bit.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip ans[0], or only return the bit count of n (that is 191)', 'next' => 'wrong_n'],
                ['label' => 'O(n) one pass; both recurrences are linear', 'next' => 'cpx'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. The answer is the whole prefix 0 through n, not a single integer. Index 0 is 0 ones.\nStep back to when you omitted 0 or collapsed to 191.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Space is the answer array.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Drop lowest 1, reuse prefix. Not builtin popcount', 'next' => 'success'],
                ['label' => 'Return how many 1-bits n itself has', 'next' => 'wrong_only'],
            ],
        ],
        'wrong_only' => [
            'message' => "You are wrong. The judge wants ans[0..n], not Number of 1 Bits on n alone.\nStep back to when you returned one count.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. ans[i] = ans[i AND (i−1)] + 1 (or shift plus last bit). Linear pass. Not builtin popcount.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
