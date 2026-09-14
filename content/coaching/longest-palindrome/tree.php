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
            'message' => "Problem: string s, length 1 to 2000, letters only, case-sensitive. Return the length of the longest palindrome you can build by rearranging those letters. abccccdd → 7 (dccaccd). a → 1. Aa is not a palindrome.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat this as Longest Palindromic Substring (5): find a contiguous span in s', 'next' => 'wrong_5'],
                ['label' => 'You may rearrange. Count each letter. Pair even counts; at most one odd leftover is the center', 'next' => 'count'],
            ],
        ],
        'wrong_5' => [
            'message' => "You are wrong here. 5 asks for a contiguous substring. Here you pick letters from anywhere and build a new string. Valid Palindrome (125) only checks after stripping, it does not build.\nStep back to when you searched a contiguous span.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'count' => [
            'message' => "For each count v, add the even part (floor(v/2) times 2) to ans. If ans is still less than n, some letter had an odd leftover — add 1 for the center. Palindrome Permutation (266) only asks true/false.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat A and a as the same letter, or add every odd count as a center', 'next' => 'wrong_case'],
                ['label' => 'Case-sensitive. At most one center. abccccdd uses 6 paired letters plus one c', 'next' => 'kind'],
            ],
        ],
        'wrong_case' => [
            'message' => "You are wrong. A and a cannot pair. Multiple odd leftovers cannot all sit in the middle; only one leftover letter can, and the rest of those odds drop one.\nStep back to when you mixed case or stacked several centers.",
            'outcome' => 'wrong',
            'rewind_to' => 'count',
            'choices' => [],
        ],
        'kind' => [
            'message' => "If every count is even, ans already equals n — do not add an extra 1. Time O(n), space O(alphabet).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Even pairs plus at most one center. abccccdd → 7. a → 1. Not 5', 'next' => 'success'],
                ['label' => 'Always return n, or require the palindrome to use every letter', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. Odd leftovers beyond one letter are unused. The answer can be shorter than n.\nStep back to when you forced using every letter.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Even part of every count, plus 1 if anything is leftover. Case-sensitive. Not 5.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
