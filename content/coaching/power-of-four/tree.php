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
            'message' => "Problem: true iff n equals 4 to a non-negative integer power. 16 → true. 5 → false. 1 → true (4 to the 0). Follow-up: no loop, no recursion.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only Power of Two (231), or loop n = n / 4, or treat this as Power of Three (326)', 'next' => 'wrong_231'],
                ['label' => 'n > 0, one 1-bit, and that bit sits on an even index', 'next' => 'bits'],
            ],
        ],
        'wrong_231' => [
            'message' => "You are wrong here. 231 accepts 2, 8, 32 — those are not powers of four. A divide-by-4 loop fails the follow-up. 326 divides by 3.\nStep back to when you stopped at 231, looped, or reached for 326.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'bits' => [
            'message' => "n > 0. n AND (n minus 1) equals 0 (exactly one 1-bit). n AND 0xAAAAAAAA equals 0: that mask has 1s on odd indices, so the lone 1 must sit on an even index (LSB is index 0). 8 is 1000 binary and fails the mask. 4 is 100 binary and passes.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Allow n ≤ 0, or skip the odd-bit mask so 2 and 8 pass', 'next' => 'wrong_mask'],
                ['label' => '1 and 16 true; 5 and 8 false. All three checks, O(1)', 'next' => 'cpx'],
            ],
        ],
        'wrong_mask' => [
            'message' => "You are wrong. Zero and negatives are out. Without the 0xAAAAAAAA check, every power of two would look true.\nStep back to when you dropped n > 0 or the even-index mask.",
            'outcome' => 'wrong',
            'rewind_to' => 'bits',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(1), space O(1). 4 to an even power of two is the same as one 1-bit on an even index.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Positive, one 1-bit, even index. Not 231 alone', 'next' => 'success'],
                ['label' => 'Return true for 8, or count 1-bits with a loop (191)', 'next' => 'wrong_8'],
            ],
        ],
        'wrong_8' => [
            'message' => "You are wrong. 8 is 2 cubed, not 4 to any integer. 191 counts bits; here you already know the count must be one, in O(1).\nStep back to when you accepted 8 or counted bits in a loop.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. n > 0, n AND (n minus 1) is 0, and n AND 0xAAAAAAAA is 0. Not 231 alone. Not a divide loop.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
