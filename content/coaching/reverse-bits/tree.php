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
            'message' => "Problem: reverse the 32 bits of n. 43261596 → 964176192. 2147483644 → 1073741822. n is even, 0 through 2³¹ − 2.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse the decimal digits, or count set bits like Number of 1 Bits', 'next' => 'other'],
                ['label' => 'For i from 0 through 31: OR (n AND 1) into bit 31 minus i of ans, then shift n right', 'next' => 'loop'],
            ],
        ],
        'other' => [
            'message' => "Decimal reverse is a different problem. Hamming weight counts 1s; it does not swap bit 0 with bit 31.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stop as soon as n becomes 0, skipping leftover high zeros', 'next' => 'wrong_stop'],
                ['label' => 'Always 32 peels so leading zeros become trailing zeros', 'next' => 'loop'],
            ],
        ],
        'wrong_stop' => [
            'message' => "You are wrong here.\nStopping at the last 1 drops the leading zeros of the 32-bit word. Early-exit is only safe if ans is already 0 in those slots — still think in 32 steps.\nStep back to when you treated leftover zeros as optional.",
            'outcome' => 'wrong',
            'rewind_to' => 'other',
            'choices' => [],
        ],
        'loop' => [
            'message' => "ans starts at 0. Bit 0 of n lands at bit 31; bit 31 lands at 0. Follow-up: cache 256 reversed bytes and assemble four lookups.\nWhat is 43261596 reversed?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '964176192', 'next' => 'cpx'],
                ['label' => 'The decimal reverse, or 43261596 still', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. The sample maps 00000010100101000001111010011100 to 00111001011110000010100101000000, which is 964176192.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'loop',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time is O(1) because the loop is 32 steps. Space O(1). Unsigned right shift in languages that sign-extend.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '32 peels of the low bit into 31 minus i; empty leftover means a shorter word, not a stop', 'next' => 'success'],
                ['label' => 'O(log n) variable bit width, reverse only until n is 0', 'next' => 'wrong_cpx'],
            ],
        ],
        'wrong_cpx' => [
            'message' => "You are wrong. The width is fixed at 32. Variable-width reverse is not this problem.\nStep back to when you scored complexity.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. For i from 0 through 31, park n AND 1 at bit 31 minus i, then shift n right. Not decimal reverse, not Hamming weight. O(1) / O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
