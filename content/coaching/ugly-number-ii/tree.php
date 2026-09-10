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
            'message' => "Problem: return the nth ugly number (prime factors only 2, 3, 5). Sequence 1, 2, 3, 4, 5, 6, 8, 9, 10, 12. n = 10 → 12. n = 1 → 1. 1 ≤ n ≤ 1690.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Ugly Number (263): scan every integer and keep those that divide out to 1 until you have n of them', 'next' => 'scan'],
                ['label' => 'dp[0] = 1; three pointers; next slot is min of ×2, ×3, ×5 from those indices', 'next' => 'dp'],
            ],
        ],
        'scan' => [
            'message' => "263 tests one n. Trial-dividing every integer until you collect 1690 uglies is too slow.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count Primes sieve up to a guessed bound and pick the nth survivor', 'next' => 'wrong_sieve'],
                ['label' => 'Generate in order: every ugly is some earlier ugly times 2, 3, or 5', 'next' => 'dp'],
            ],
        ],
        'wrong_sieve' => [
            'message' => "You are wrong here.\nCount Primes marks composites. You do not know a tight upper bound, and you only need factors 2, 3, 5.\nStep back to when you sieved all primes.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'dp' => [
            'message' => "next2 = dp[p2] × 2, next3 = dp[p3] × 3, next5 = dp[p5] × 5. Write the min. Then increment every pointer whose candidate equals that min.\nWhy every matching pointer, not just one?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '6 is both 2 × 3 and 3 × 2; bumping only p2 would emit 6 twice', 'next' => 'cpx'],
                ['label' => 'Bump only the first matching pointer; duplicates are fine because the problem allows repeats', 'next' => 'wrong_dup'],
            ],
        ],
        'wrong_dup' => [
            'message' => "You are wrong. The sequence is strictly increasing unique uglies. 6 must appear once.\nStep back to when you advanced only one pointer.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "n = 10 → 12 (8 is 2³, do not skip it). Heap twin: pop min, push ×2 ×3 ×5 with a set. DP is O(n).\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Three pointers, min of three, advance all ties. 10 → 12. Not 263’s yes/no test', 'next' => 'success'],
                ['label' => 'Return whether n itself is ugly (263) instead of the nth ugly value', 'next' => 'wrong_263'],
            ],
        ],
        'wrong_263' => [
            'message' => "You are wrong. This problem asks for the nth ugly number, not whether n is ugly.\nStep back to when you answered 263.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dp[0] = 1. Next is min of ×2, ×3, ×5. Advance every pointer that produced that min. 10 → 12. Heap plus a set is the slower twin. Not scan-every-integer, not 263.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
