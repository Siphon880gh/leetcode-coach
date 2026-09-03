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
            'message' => "Problem: return whether s is a valid number. \"0\" and \"4.\" and \"-.9\" and \"2e10\" are true. \"e\", \".\", \"1e\", \"e3\", and \"99e2.5\" are false. Length ≤ 20.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hand s to the language float parser and see if it succeeds', 'next' => 'as_lib'],
                ['label' => 'Scan: optional leading +/-; then one significand with at most one dot; then optional e/E plus an integer', 'next' => 'scan'],
            ],
        ],
        'as_lib' => [
            'message' => "Library parsers accept inf, hex, and locale forms this spec rejects. This problem is a strict grammar, not “can the runtime parse it”.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'If parseFloat consumes any prefix, return true', 'next' => 'wrong_prefix'],
                ['label' => 'Walk the string once and reject extra dots, extra e, and missing digits', 'next' => 'scan'],
            ],
        ],
        'wrong_prefix' => [
            'message' => "You are wrong here.\n\"1a\" must be false even though it starts with a digit. The whole string has to match.\nStep back to when you trusted a language parse.",
            'outcome' => 'wrong',
            'rewind_to' => 'as_lib',
            'choices' => [],
        ],
        'scan' => [
            'message' => "After an optional sign, reject a lone \".\" or \".e\". Why is \"4.\" true but \".\" false?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The significand needs at least one digit; a trailing or leading dot is allowed only if a digit is present', 'next' => 'exp'],
                ['label' => 'Any dot is invalid; integers are the only valid numbers', 'next' => 'wrong_nodot'],
            ],
        ],
        'wrong_nodot' => [
            'message' => "You are wrong. \"4.\" and \"-.9\" are valid. A dot with no digits on either side is the failure.\nStep back to when you banned every decimal.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'exp' => [
            'message' => "e or E may appear once, not first, not last. After it, an optional +/- then digits. No second dot. Writeup time O(n), space O(1).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'true iff the whole string matched — a boolean, not a parsed integer like atoi', 'next' => 'success'],
                ['label' => 'The numeric value; Valid Number is the same as String to Integer (atoi)', 'next' => 'wrong_atoi'],
            ],
        ],
        'wrong_atoi' => [
            'message' => "You are wrong. This problem returns a boolean. atoi scans then clamps a 32-bit int; it does not implement this exponent grammar.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'exp',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Optional sign, then a significand with one optional dot and at least one digit, then optional e/E plus an integer (optional sign, then digits). Time O(n). Grammar scan — not language float, and not atoi.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
