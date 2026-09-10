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
            'message' => "Problem: distinct positives, n up to 1000. Return any largest subset where for every pair, one divides the other. [1,2,3] → [1,2] or [1,3]. [1,2,4,8] → the whole array.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'LIS in the original order (300): compare values, never sort, never test divisibility', 'next' => 'wrong_lis'],
                ['label' => 'Sort, then DP: f[i] is the longest divisible chain ending at nums[i]', 'next' => 'dp'],
            ],
        ],
        'wrong_lis' => [
            'message' => "You are wrong here. This is a subset, so order does not matter. 300 keeps sequence order and never asks whether one number divides another.\nStep back to when you treated this as LIS.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dp' => [
            'message' => "After sorting, a larger value may follow a smaller one iff larger mod smaller is 0. Transitivity: a divides b and b divides c implies a divides c. f[i] starts at 1. For j < i, if nums[i] mod nums[j] is 0, f[i] = max(f[i], f[j] + 1). Remember the index k of the best f.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return only the length f[k], or skip reconstruction of the values', 'next' => 'wrong_len'],
                ['label' => 'Walk i down from k: take nums[i] when it divides nums[k] and f[i] equals the remaining length', 'next' => 'kind'],
            ],
        ],
        'wrong_len' => [
            'message' => "You are wrong. The judge wants the subset values, not just how many.\nStep back to when you returned only a length.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'kind' => [
            'message' => "GCD of the whole array being 1 does not kill a subset (1 with 2 still works). Power-set search is too slow at n = 1000.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort plus divisible LIS DP, reconstruct from k. Not 300. Not length-only', 'next' => 'success'],
                ['label' => 'If gcd of all nums is 1, return empty, or enumerate every subset', 'next' => 'wrong_gcd'],
            ],
        ],
        'wrong_gcd' => [
            'message' => "You are wrong. Pairwise divisibility can still hold when the global gcd is 1. Enumerating 2^n subsets will not finish.\nStep back to when you used global gcd or brute subsets.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort, then longest chain where each later value is a multiple of an earlier one. Reconstruct from the best index. [1,2,3] → [1,2] or [1,3]. Not 300.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
