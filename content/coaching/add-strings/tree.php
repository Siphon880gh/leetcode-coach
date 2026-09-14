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
            'message' => "Problem: two non-negative integers as digit strings, each length 1 to 1e4, no leading zeros except 0. Return their sum as a string. Do not parse the whole string into a language integer. 11 + 123 → 134. 456 + 77 → 533. 0 + 0 → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Parse with int() or BigInt, or walk digits from the left', 'next' => 'wrong_parse'],
                ['label' => 'Walk from the last character of each string. Add digit plus carry', 'next' => 'carry'],
            ],
        ],
        'wrong_parse' => [
            'message' => "You are wrong here. Length 1e4 will not fit a 64-bit int, and the statement forbids converting the whole input. Adding from the left misaligns place values.\nStep back to when you parsed the whole string or started at the MSD.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'carry' => [
            'message' => "Missing digits count as 0. Sum a + b + carry, append the ones digit, set carry to the tens. Keep looping while either index remains or carry is nonzero, so 9 + 1 becomes 10.\nThen?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Drop a leftover carry, or return the digits in LSD-first order', 'next' => 'wrong_rev'],
                ['label' => 'Reverse (or build from the front). Leftover carry is a new leading 1', 'next' => 'kind'],
            ],
        ],
        'wrong_rev' => [
            'message' => "You are wrong. Digits were appended least-significant first, so reverse before joining. A leftover carry of 1 is a real extra digit.\nStep back to when you skipped the reverse or the final carry.",
            'outcome' => 'wrong',
            'rewind_to' => 'carry',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Add Two Numbers (2) walks linked-list digits. Add Binary (67) is the same walk in base 2. This problem is decimal strings.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Right to left with carry. 11 + 123 → 134. Not 2 / 67', 'next' => 'success'],
                ['label' => 'Keep leading zeros in the answer besides the all-zero case', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. Inputs have no leading zeros except 0 itself, and the sum should not either (except 0 + 0 → 0).\nStep back to when you kept extra zeros.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Right to left, ones digit out, carry the tens, reverse at the end. 11 + 123 → 134. Not 2.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
