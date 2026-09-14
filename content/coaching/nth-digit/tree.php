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
            'message' => "Problem: n is 1 to 2^31−1. Write 1, 2, 3, … as one digit stream. Return the nth digit. n=3 → 3. n=11 → 0 because 10 contributes digits 1 then 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Build the concatenated string up to n, or treat this as Integer to English (273)', 'next' => 'wrong_build'],
                ['label' => 'Skip whole groups of k-digit numbers until n lands in one group', 'next' => 'blocks'],
            ],
        ],
        'wrong_build' => [
            'message' => "You are wrong here. n can be 2e9; a concatenated string will not fit. 273 spells numbers in words, not digits in an infinite stream.\nStep back to when you built the string or used 273.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'blocks' => [
            'message' => "Start k=1, cnt=9 (how many k-digit numbers). While k times cnt is less than n, subtract that many digits from n, then k += 1 and multiply cnt by 10. Use a 64-bit product — 9×10^8 times 9 already overflows 32-bit. Then the number is 10^(k−1) plus (n−1) / k, and the digit is index (n−1) mod k.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Use 1-based (n / k) without subtracting 1, or skip the 64-bit cast', 'next' => 'wrong_off'],
                ['label' => '0-based offset (n−1). Widen k times cnt. Then index into that number', 'next' => 'kind'],
            ],
        ],
        'wrong_off' => [
            'message' => "You are wrong. n=11: after the 9 one-digit numbers you have 2 left, so you want the 2nd digit among two-digit numbers, which is the 0 of 10, not the 1 of 11. And k times cnt as 32-bit int can wrap and skip the loop too early.\nStep back to when you used n/k without −1 or overflowed the product.",
            'outcome' => 'wrong',
            'rewind_to' => 'blocks',
            'choices' => [],
        ],
        'kind' => [
            'message' => "One-digit block is 9 digits, two-digit is 180, three-digit is 2700, and so on. Time is O(log n) because k grows with digit length.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip length-k blocks. n=11 → 0. Not string-build', 'next' => 'success'],
                ['label' => 'Count 0 as a one-digit number, or start the stream at 0', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. The sequence starts at 1. Zero first appears as the second digit of 10.\nStep back to when you included leading zeros or started at 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Skip k-digit blocks, then pick the number and the digit. n=3 → 3. n=11 → 0. Not string-build.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
