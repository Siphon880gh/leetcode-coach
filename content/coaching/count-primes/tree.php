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
            'message' => "Problem: how many primes are strictly less than n. 10 → 4 (2, 3, 5, 7). 0 and 1 → 0. n up to 5 × 10⁶.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Trial-divide every i < n, or count primes ≤ n (include n if prime)', 'next' => 'trial'],
                ['label' => 'Sieve: flags 0..n−1; if i is still true, count it and mark 2i, 3i, … false', 'next' => 'sieve'],
            ],
        ],
        'trial' => [
            'message' => "Five million trial divisions time out. The problem is strictly less than n, so 10 does not count even though 10 is composite — 11 would not count either.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Basic Calculator: stack plus/minus and parens', 'next' => 'wrong_calc'],
                ['label' => 'Eratosthenes: mark multiples of each remaining prime; count what stays true', 'next' => 'sieve'],
            ],
        ],
        'wrong_calc' => [
            'message' => "You are wrong here.\nBasic Calculator evaluates an expression string. This counts primes below n.\nStep back to when you reused the calculator.",
            'outcome' => 'wrong',
            'rewind_to' => 'trial',
            'choices' => [],
        ],
        'sieve' => [
            'message' => "Start the inner walk at 2i, not i, so you do not un-count the prime. 1 is never visited. n < 2 yields 0. Starting at i×i is a speedup, same answer.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '10 is 4; 0 and 1 are 0', 'next' => 'cpx'],
                ['label' => '10 is 5 if 1 is prime, or 4 including 10', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. 1 is not prime. 10 is not less than 10. The four primes are 2, 3, 5, 7.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'sieve',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n log log n). Space O(n) for the flags.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sieve, count i < n; not trial-divide, not include n, not treat 1 as prime', 'next' => 'success'],
                ['label' => 'Mark starting at i so the prime itself is cleared, then count remaining trues including 0 and 1', 'next' => 'wrong_self'],
            ],
        ],
        'wrong_self' => [
            'message' => "You are wrong. Clearing i itself would drop every prime. 0 and 1 stay unused; you only count remaining true i from 2.\nStep back to when you marked the prime itself.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sieve of Eratosthenes: count each remaining i, mark multiples from 2i. Strictly less than n. O(n log log n). Not trial-divide, not include n, not Basic Calculator.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
