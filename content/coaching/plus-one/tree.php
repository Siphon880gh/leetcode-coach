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
            'message' => "Problem: digits is a large integer, most-significant first, no leading zeros. Add one and return the digit array. [1,2,3] → [1,2,4]. [9] → [1,0]. Length ≤ 100.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Join the digits into an int, add 1, then split back into digits', 'next' => 'as_int'],
                ['label' => 'Walk from the last index: add 1, mod 10; if the digit is not 0, return; if all 9s, prepend 1', 'next' => 'carry'],
            ],
        ],
        'as_int' => [
            'message' => "Length can be 100. A 100-digit value does not fit in 32-bit or 64-bit integers. This is digit arithmetic, not language bigint.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Still join, but use a 128-bit type', 'next' => 'wrong_wide'],
                ['label' => 'Start at the least-significant digit and propagate a carry of 1', 'next' => 'carry'],
            ],
        ],
        'wrong_wide' => [
            'message' => "You are wrong here.\n100 digits is far past 128 bits. You never convert the whole array to a machine integer.\nStep back to when you joined the digits.",
            'outcome' => 'wrong',
            'rewind_to' => 'as_int',
            'choices' => [],
        ],
        'carry' => [
            'message' => "After digits[i] += 1 and %= 10, why return immediately if the digit is not 0?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The carry died; every digit to the left stays the same', 'next' => 'nines'],
                ['label' => 'You still prepend 1, so [1,2,3] becomes [1,1,2,4]', 'next' => 'wrong_pre'],
            ],
        ],
        'wrong_pre' => [
            'message' => "You are wrong. Prepend 1 only when every digit rolled to 0 (the number was all 9s). [1,2,3] stays length 3.\nStep back to when you always grew the array.",
            'outcome' => 'wrong',
            'rewind_to' => 'carry',
            'choices' => [],
        ],
        'nines' => [
            'message' => "[9,9] becomes [0,0] in the loop, then [1]+digits → [1,0,0]. Writeup time O(n); extra space O(1) besides the answer.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The digit array — not a single integer 10, and not a linked list like Add Two Numbers', 'next' => 'success'],
                ['label' => 'The integer value; Plus One is the same as Add Two Numbers', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. The signature returns an array of digits. Add Two Numbers walks two reversed linked lists.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'nines',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. From the right, add 1 and mod 10; return as soon as a digit is not 0. If the loop finishes, the number was all 9s — prepend 1. Time O(n). Digit carry — not joining into an int, and not Add Two Numbers.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
