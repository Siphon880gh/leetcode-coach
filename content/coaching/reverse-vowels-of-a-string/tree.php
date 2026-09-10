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
            'message' => "Problem: reverse only the vowels of s. Vowels are a e i o u in both cases. IceCreAm → AceCreIm. leetcode → leotcede. Length up to 3e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse the whole string (344), or reverse words (151), or treat y as a vowel', 'next' => 'wrong_344'],
                ['label' => 'Two pointers: skip consonants, swap when both sit on vowels', 'next' => 'ptr'],
            ],
        ],
        'wrong_344' => [
            'message' => "You are wrong here. 344 reverses every character. 151 reverses tokens. y is not a vowel in this problem.\nStep back to when you fully reversed, reversed words, or included y.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'ptr' => [
            'message' => "Char array. i = 0, j = n−1. While i < j: advance i while not a vowel; retreat j while not a vowel; if i < j, swap, then i += 1 and j −= 1. Consonants stay. Case is preserved (A stays A).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Ignore uppercase, or swap a vowel with a consonant', 'next' => 'wrong_case'],
                ['label' => 'aeiouAEIOU set. Time O(n). Return the joined string', 'next' => 'cpx'],
            ],
        ],
        'wrong_case' => [
            'message' => "You are wrong. A is a vowel. Swapping a vowel with a consonant moves letters that should stay put (IceCreAm would break).\nStep back to when you dropped uppercase or swapped with consonants.",
            'outcome' => 'wrong',
            'rewind_to' => 'ptr',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Space O(n) for the char array on immutable strings. A 128-slot table is O(1) per vowel check.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip consonants, swap vowels. Not 344. y is not a vowel', 'next' => 'success'],
                ['label' => 'Return s unchanged, or reverse only lowercase aeiou', 'next' => 'wrong_ret'],
            ],
        ],
        'wrong_ret' => [
            'message' => "You are wrong. IceCreAm must become AceCreIm. Skipping uppercase vowels leaves I and A unmoved.\nStep back to when you skipped uppercase or returned s unchanged.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Skip consonants; swap aeiou both cases. Not a full reverse. y is not a vowel.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
