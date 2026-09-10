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
            'message' => "Problem: true iff n is a positive integer whose only prime factors are 2, 3, and 5. 6 → true (2 × 3). 1 → true (no primes). 14 → false (factor 7). n can be 0 or negative.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sieve every integer up to n (Count Primes) and check the factor list', 'next' => 'sieve'],
                ['label' => 'If n < 1, false; else divide out 2, 3, and 5; leftover must be 1', 'next' => 'div'],
            ],
        ],
        'sieve' => [
            'message' => "Count Primes builds a table up to n. Here you test one integer. Trial-dividing every prime is extra work.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Ugly Number II: generate the nth ugly value with three pointers', 'next' => 'wrong_ii'],
                ['label' => 'Only 2, 3, and 5 matter. Strip those factors; if 1 remains, n was ugly', 'next' => 'div'],
            ],
        ],
        'wrong_ii' => [
            'message' => "You are wrong here.\nUgly Number II asks for the nth ugly number. This problem only tests one n.\nStep back to when you generated a sequence.",
            'outcome' => 'wrong',
            'rewind_to' => 'sieve',
            'choices' => [],
        ],
        'div' => [
            'message' => "For each of 2, 3, 5: while n % x == 0, n = n / x. Then return n == 1. 6 becomes 1. 14 sticks at 7. 1 never enters the loops.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '6 true, 1 true, 14 false. 8 is 2³ so true. 0 and negatives false', 'next' => 'cpx'],
                ['label' => '1 is false because it has no factors, or 8 is false because it is a pure power of 2', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. 1 has no prime factors other than 2, 3, 5. 8 is 2 × 2 × 2, still ugly.\nStep back to when you scored 1 or 8.",
            'outcome' => 'wrong',
            'rewind_to' => 'div',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(log n) divisions, O(1) space. Power of Two only strips 2. Do not skip n < 1.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reject n < 1; divide out 2, 3, 5; leftover 1. Not a sieve, not Ugly II', 'next' => 'success'],
                ['label' => 'Skip the n < 1 check; 0 is even so keep dividing by 2', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. 0 is not a positive integer. Dividing 0 by 2 loops forever.\nStep back to when you skipped the n < 1 guard.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. n < 1 is false. Divide out 2, 3, and 5; leftover must be 1. 1 and 8 are ugly; 14 is not. Not Count Primes, not Ugly Number II.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
