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
            'message' => "Problem: add two binary strings and return a binary string. \"11\" + \"1\" → \"100\". \"1010\" + \"1011\" → \"10101\". Lengths up to 10^4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Parse both as ints, add, then convert the sum back to binary', 'next' => 'as_int'],
                ['label' => 'Two pointers from the last chars: add bits plus carry, append carry % 2, keep carry // 2', 'next' => 'carry'],
            ],
        ],
        'as_int' => [
            'message' => "10^4 bits do not fit in a 64-bit integer. This is the same trap as Plus One: do digit (here bit) arithmetic on the characters.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Still parse, but use a 128-bit type', 'next' => 'wrong_wide'],
                ['label' => 'Walk both strings from the right with a carry of 0, 1, or 2 (then 3 if both 1s plus carry)', 'next' => 'carry'],
            ],
        ],
        'wrong_wide' => [
            'message' => "You are wrong here.\n10^4 bits is far past 128 bits. You never convert the whole string to a machine integer.\nStep back to when you parsed a and b as ints.",
            'outcome' => 'wrong',
            'rewind_to' => 'as_int',
            'choices' => [],
        ],
        'carry' => [
            'message' => "The loop is while i >= 0 or j >= 0 or carry. Why keep going after both strings are exhausted?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A leftover carry is a new high bit: "11" + "1" needs that extra 1 to make "100"', 'next' => 'mod'],
                ['label' => 'Stop when both pointers are done; drop any leftover carry', 'next' => 'wrong_drop'],
            ],
        ],
        'wrong_drop' => [
            'message' => "You are wrong. Dropping the last carry turns \"11\" + \"1\" into \"00\". The extra 1 is the 4s place.\nStep back to when you ended the loop too soon.",
            'outcome' => 'wrong',
            'rewind_to' => 'carry',
            'choices' => [],
        ],
        'mod' => [
            'message' => "Each step uses divmod by 2, then reverse the collected bits. Writeup time O(max(m, n)); extra O(1) besides the answer.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The binary string — not a decimal digit array like Plus One, and not a linked list', 'next' => 'success'],
                ['label' => 'digits[i] += 1 and % 10; Add Binary is Plus One on a', 'next' => 'wrong_plus'],
            ],
        ],
        'wrong_plus' => [
            'message' => "You are wrong. Plus One adds 1 to a decimal digit array. Here you add two binary strings, bit by bit, mod 2.\nStep back to when you reused Plus One.",
            'outcome' => 'wrong',
            'rewind_to' => 'mod',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. From the right, add bits plus carry, append carry % 2, set carry to carry // 2. Continue while either string or carry remains. Reverse. Time O(max(m, n)). Bit strings — not parsing as int, and not Plus One.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
