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
            'message' => "Problem: myAtoi(s) — skip leading spaces, read an optional sign, then digits, clamp to 32-bit.\n\"42\" → 42, \"   -042\" → −42, \"1337c0d3\" → 1337.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hand the whole string to the language parseInt / int()', 'next' => 'as_lib'],
                ['label' => 'Scan left to right: spaces, then sign, then digits until a non-digit', 'next' => 'scan'],
            ],
        ],
        'as_lib' => [
            'message' => "Library parsers do not follow this spec. \"words and 987\" must be 0 (stop at \'w\'), not 987.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Grab the last integer that appears anywhere in s', 'next' => 'wrong_last'],
                ['label' => 'Only consume a prefix: spaces, one optional sign, then a digit run', 'next' => 'scan'],
            ],
        ],
        'wrong_last' => [
            'message' => "You are wrong here.\nYou never search later in the string. If the first non-space is not a sign or digit, the answer is 0.\nStep back to when you chose what to parse.",
            'outcome' => 'wrong',
            'rewind_to' => 'as_lib',
            'choices' => [],
        ],
        'scan' => [
            'message' => "\"0-1\" reads the digit 0, then \'-\' is a non-digit so you stop. Result 0, not −1.\nWhen do you stop converting?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'At the first non-digit after the optional sign — even if more numbers follow', 'next' => 'clamp'],
                ['label' => 'Keep going so a minus in the middle starts a new signed number', 'next' => 'wrong_mid'],
            ],
        ],
        'wrong_mid' => [
            'message' => "You are wrong. A sign is allowed only once, immediately after the spaces. Later \'-\' just ends the digit run.\nStep back to when you defined the stop rule.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'clamp' => [
            'message' => "Unlike Reverse Integer (return 0), atoi *clamps* to [−2³¹, 2³¹−1]. Check before res × 10 + digit, same mx//10 trick.\nIf the next digit would overflow, what do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '2³¹−1 when sign is +, or −2³¹ when sign is −', 'next' => 'zeros'],
                ['label' => '0, matching Reverse Integer', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. This problem rounds into range: too big → 2³¹−1, too small → −2³¹.\nStep back to when you handled overflow.",
            'outcome' => 'wrong',
            'rewind_to' => 'clamp',
            'choices' => [],
        ],
        'zeros' => [
            'message' => "\"   -042\": skip spaces, sign −, digits 0,4,2 → value 42 with sign −. No digits after the sign → 0.\nWhat do you return at the end?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'sign × res in O(n) time, O(1) extra space', 'next' => 'success'],
                ['label' => 'The original string length, because leading spaces count', 'next' => 'wrong_spaces'],
            ],
        ],
        'wrong_spaces' => [
            'message' => "You are wrong. Spaces are discarded; they are not digits and they do not affect the magnitude.\nStep back to when you finished the scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'zeros',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Prefix scan: skip spaces, one sign, digits until a non-digit; clamp to 32-bit instead of returning 0. Time O(n), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
