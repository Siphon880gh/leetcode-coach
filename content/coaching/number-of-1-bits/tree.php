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
            'message' => "Problem: Hamming weight of n — how many 1s in binary. 11 → 3 (1011). 128 → 1. 2147483645 → 30. n from 1 through 2³¹ − 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse the 32 bits, or count decimal digits', 'next' => 'other'],
                ['label' => 'While n is nonzero: n becomes n AND (n minus 1), then add 1 to the answer', 'next' => 'kern'],
            ],
        ],
        'other' => [
            'message' => "Reverse Bits rearranges slots. Decimal length is not Hamming weight.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Shift and test n AND 1 exactly 32 times only; never stop early', 'next' => 'wrong_width'],
                ['label' => 'Kernighan: each AND with n minus 1 clears the lowest 1', 'next' => 'kern'],
            ],
        ],
        'wrong_width' => [
            'message' => "You are wrong here.\nShift-and-test does work, but you may stop when n is 0. Forcing 32 peels is Reverse Bits thinking, not popcount.\nStep back to when you treated 32 as mandatory.",
            'outcome' => 'wrong',
            'rewind_to' => 'other',
            'choices' => [],
        ],
        'kern' => [
            'message' => "11 (1011) → 1010 → 1000 → 0, three ticks. Loop length equals the number of 1s, not the word width. Follow-up: cache 256 eight-bit popcounts.\nWhat is the sample for 11?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '3', 'next' => 'cpx'],
                ['label' => '2 (value of the last 1) or 4 (decimal digits)', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. 1011 has three set bits. The last 1’s place value is 1, not the answer.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'kern',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(k) for k set bits (at most 32). Space O(1).\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'n AND (n minus 1) until n is 0; ans is the tick count', 'next' => 'success'],
                ['label' => 'Return n itself, or log n of the highest bit', 'next' => 'wrong_cpx'],
            ],
        ],
        'wrong_cpx' => [
            'message' => "You are wrong. Hamming weight is the count of 1s, not the integer and not the index of the top bit.\nStep back to when you scored the result.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. While n is nonzero, n AND (n minus 1) drops the lowest 1 and the counter ticks. Not Reverse Bits, not decimal digits. O(k) / O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
