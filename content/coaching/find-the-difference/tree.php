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
            'message' => "Problem: t is a shuffle of s plus one extra lowercase letter (t is one longer; s may be empty). Return the added letter. abcd / abcde → e. empty / y → y. Lengths up to 1000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat this as first unique in one string (387), or assume the extra is always the last char of t', 'next' => 'wrong_387'],
                ['label' => 'Count s then spend on t, or XOR / sum the code points of both strings', 'next' => 'cnt'],
            ],
        ],
        'wrong_387' => [
            'message' => "You are wrong here. 387 looks for a letter that appears once in one string. The extra letter can sit anywhere in t, not only at the end.\nStep back to when you used 387 or trusted the last index.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'cnt' => [
            'message' => "Counter(s). Walk t and decrement; when a count goes negative, that character is extra. XOR of every character in s and t leaves the extra. Sum of code points: chr(sum(t) minus sum(s)). Sorting both and scanning for the first mismatch also works but is slower.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return a letter that already existed in s just because it moved', 'next' => 'wrong_move'],
                ['label' => 'The extra is the letter whose count in t is one higher, wherever it sits', 'next' => 'kind'],
            ],
        ],
        'wrong_move' => [
            'message' => "You are wrong. Shuffling does not add a letter. abcd / bacd would not be this problem; abcde added e.\nStep back to when you scored a moved letter as extra.",
            'outcome' => 'wrong',
            'rewind_to' => 'cnt',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Single Number (136) XORs integers. Here you XOR or count letters. Empty s is valid: the whole of t is the extra letter.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count, XOR, or sum. abcd / abcde → e. empty / y → y. Not 387 / 136', 'next' => 'success'],
                ['label' => 'Skip the empty-s case, or XOR only the integers 136-style without the strings', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. empty / y is y. 136 is a bag of ints, not two shuffled strings.\nStep back to when you skipped empty s or used 136.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Count s, spend on t; or XOR / sum. abcd / abcde → e. empty / y → y. Not 387. Not 136.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
