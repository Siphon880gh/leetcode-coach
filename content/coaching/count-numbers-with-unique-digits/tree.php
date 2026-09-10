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
            'message' => "Problem: count integers x with all distinct digits where 0 ≤ x < 10^n. n is 0..8. n = 2 → 91 (0..99 except 11, 22, …, 99). n = 0 → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Loop every integer from 0 to 10^n − 1 and test digit uniqueness', 'next' => 'wrong_enum'],
                ['label' => 'Add a closed formula per length (or digit DP with a used-digit mask)', 'next' => 'layers'],
            ],
        ],
        'wrong_enum' => [
            'message' => "You are wrong here. n can be 8, so the range is 1e8. The count is a handful of permutations, not a scan.\nStep back to when you enumerated the range.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'layers' => [
            'message' => "n = 0 is 1 (just 0). Length 1 contributes 10. For length k from 2 to n: first digit 9 choices (1..9), then 9, 8, … leftover: 9 × 9 × 8 × … × (11 − k). Sum the layers.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'n = 0 returns 0, or the first digit of a k-digit number may be 0', 'next' => 'wrong_zero'],
                ['label' => 'n = 0 is 1. Leading digit is 1..9. Digit DP treats leading zeros as unused', 'next' => 'dp'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. The empty-width range still counts 0. A true k-digit number cannot start with 0.\nStep back to when you dropped n = 0 or allowed a leading zero in the product.",
            'outcome' => 'wrong',
            'rewind_to' => 'layers',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Digit DP walks n positions from the high end with a 10-bit used mask and a lead flag. Leading zeros do not set a bit, so shorter numbers are included. dfs(n−1, 0, true) is the same total.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sum length layers, or mask DP with leading zeros free. n = 2 is 91. Not a range scan', 'next' => 'success'],
                ['label' => 'Mark 0 as used while still in the leading-zero prefix, so 7 is never counted', 'next' => 'wrong_mask'],
            ],
        ],
        'wrong_mask' => [
            'message' => "You are wrong. A leading zero is padding, not the digit 0. Marking it used drops every shorter number.\nStep back to when you set the 0-bit on a leading zero.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One-digit 10, then 9 × 9 × 8 × … for longer lengths. n = 2 → 91. n = 0 → 1. Digit DP with a lead flag matches. Not a loop to 10^n.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
