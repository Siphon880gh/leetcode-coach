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
            'message' => "Problem: Excel title → column number. A is 1, Z is 26, AA is 27, AB is 28. \"A\" → 1. \"AB\" → 28. \"ZY\" → 701. Uppercase, length 1 to 7.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Subtract 1 like Column Title, treat A as 0, or reverse the string first', 'next' => 'inverse'],
                ['label' => 'Horner from the left: ans becomes ans times 26 plus this letter’s 1-based value', 'next' => 'horner'],
            ],
        ],
        'inverse' => [
            'message' => "Column Title is the inverse: number → letters with n minus 1 each step. Here the most-significant letter is already first. A is 1, not 0. Reversing would scramble place values.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A maps to 0 so AB is 1 times 26 plus 1', 'next' => 'wrong_zero'],
                ['label' => 'Walk left to right: times 26, then add (letter minus A plus 1)', 'next' => 'horner'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong here.\nA is 1. If A were 0, \"A\" would be 0, not 1, and \"AB\" would not be 28.\nStep back to when you scored A as zero.",
            'outcome' => 'wrong',
            'rewind_to' => 'inverse',
            'choices' => [],
        ],
        'horner' => [
            'message' => "\"AB\": start 0; A → 1; then 1 times 26 plus 2 → 28.\nWhat is \"ZY\"?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '701 — Z is 26, then 26 times 26 plus 25', 'next' => 'ans'],
                ['label' => '28 like AB, or 26 because Z is the last letter', 'next' => 'wrong_zy'],
            ],
        ],
        'wrong_zy' => [
            'message' => "You are wrong. \"ZY\" is 701, not a copy of AB and not a single Z.\nStep back to when you scored ZY.",
            'outcome' => 'wrong',
            'rewind_to' => 'horner',
            'choices' => [],
        ],
        'ans' => [
            'message' => "\"A\" is one letter: 0 times 26 plus 1 → 1. Time O(n), extra O(1). Not Column Title’s subtract-1 loop.\nWhat is \"A\"?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '1', 'next' => 'success'],
                ['label' => '28 or 701 from the other samples', 'next' => 'wrong_a'],
            ],
        ],
        'wrong_a' => [
            'message' => "You are wrong. A single A is 1. Do not reuse AB or ZY.\nStep back to when you scored A.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Horner base-26 from the left; A is 1. Not Column Title’s subtract-1 remainder walk. \"A\" → 1. \"AB\" → 28. \"ZY\" → 701.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
