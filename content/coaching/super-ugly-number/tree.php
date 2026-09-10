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
            'message' => "Problem: nth positive integer whose prime factors all sit in primes. n up to 1e5; answer fits 32-bit signed. n=12, primes=[2,7,13,19] → 32. n=1 → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Ugly Number (263): trial-divide every integer until you collect n hits', 'next' => 'wrong_scan'],
                ['label' => 'Ugly Number II merge, but k pointers: one per prime', 'next' => 'dp'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong here.\n263 tests one integer. Scanning up to the 1e5-th super ugly is too slow, and 2, 3, 5 are not the only primes.\nStep back to when you reused 263’s scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dp' => [
            'message' => "dp[0]=1. ptr[i]=0 for each prime. Next slot is min of dp[ptr[i]] times primes[i]. Write that min, then increment every ptr whose candidate equals it, so 2 times 7 and 7 times 2 do not duplicate 14.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Freeze the factors at 2, 3, 5, or bump only the first matching pointer', 'next' => 'wrong_264'],
                ['label' => 'O(n k) DP. Heap twin: pop min, push x times p, skip duplicates', 'next' => 'cpx'],
            ],
        ],
        'wrong_264' => [
            'message' => "You are wrong. Stream count is len(primes), not three. Ties must all advance or 14 appears twice.\nStep back to when you copied 264’s three lanes or skipped extra pointers.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "n=1 is 1 (empty prime-factor list). Do not overflow when multiplying.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'k pointers, min, advance all ties. 12 → 32. Not 263, not only 2/3/5', 'next' => 'success'],
                ['label' => 'Return whether n itself is super ugly, not the nth value', 'next' => 'wrong_test'],
            ],
        ],
        'wrong_test' => [
            'message' => "You are wrong. This asks for the nth super ugly number, not a yes/no test on n.\nStep back to when you answered a 263-style predicate.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dp[0]=1. One pointer per prime. Next is the min product; advance every pointer that hit it. 12 with [2,7,13,19] is 32. Not trial-divide, not 264’s three streams only.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
