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
            'message' => "Problem: true iff n equals 2ˣ for some integer x. Follow-up: no loop, no recursion. −2³¹ ≤ n ≤ 2³¹ − 1. 1 → true. 16 → true. 3 → false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Number of 1 Bits (191) count, or keep dividing by 2 in a loop, or log2 floating equality', 'next' => 'wrongish'],
                ['label' => 'n > 0 and (n AND (n minus 1)) equals 0 — exactly one 1-bit', 'next' => 'bit'],
            ],
        ],
        'wrongish' => [
            'message' => "191 counts how many 1s; here you need that count to be one, in O(1). A divide loop fails the follow-up. Floating log2 rounding can lie.\nWhat is the O(1) test?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Positive and n AND (n minus 1) is 0. That AND clears the lowest 1; nothing left means there was only one', 'next' => 'bit'],
                ['label' => 'Skip the n > 0 check; negatives can still be a power of two', 'next' => 'wrong_neg'],
            ],
        ],
        'wrong_neg' => [
            'message' => "You are wrong here.\n−16 is not 2ˣ in this problem. Two’s complement negatives can look sparse; reject n ≤ 0.\nStep back to when you allowed non-positives.",
            'outcome' => 'wrong',
            'rewind_to' => 'wrongish',
            'choices' => [],
        ],
        'bit' => [
            'message' => "1 is 0b1. 16 is 0b10000. 3 is 0b11 and the AND yields 2, not 0. Power of Three divides by 3; Power of Four also checks an even bit index.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '1 → true; 16 → true; 3 → false', 'next' => 'cpx'],
                ['label' => '0 is 2 to the minus-infinity so return true', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. 0 has no 1-bit and fails n > 0.\nStep back to when you accepted 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'bit',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(1) time and space. No loop. Not 191’s while-n, not log2, not Power of Three.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'n > 0 and n AND (n minus 1) is 0; not a loop, not log2, not 0, not negatives', 'next' => 'success'],
                ['label' => 'Same as Power of Four: also require the 1 on an even bit', 'next' => 'wrong_four'],
            ],
        ],
        'wrong_four' => [
            'message' => "You are wrong. 2, 8, 32 are powers of two but not of four. Do not add the even-bit check.\nStep back to when you borrowed 342.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. n > 0 and n AND (n minus 1) is 0. One 1-bit. O(1). Not a divide loop, not log2, not 0, not negatives, not Power of Four’s extra bit check.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
