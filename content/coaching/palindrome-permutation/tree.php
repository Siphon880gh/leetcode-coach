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
            'message' => "Problem: true if some permutation of s is a palindrome. Lowercase English. \"code\" → false. \"aab\" → true (aba). \"carerac\" → true (racecar).\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Check that s is already a palindrome, or generate every permutation', 'next' => 'already'],
                ['label' => 'Count letters; at most one character may have an odd count', 'next' => 'count'],
            ],
        ],
        'already' => [
            'message' => "\"aab\" is not a palindrome but aba is. Generating n! permutations is too slow at length 5000.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Palindrome Permutation II: emit every palindromic rearrangement', 'next' => 'wrong_ii'],
                ['label' => 'Pairs from the outside in; only a center letter may be odd', 'next' => 'count'],
            ],
        ],
        'wrong_ii' => [
            'message' => "You are wrong here.\nPalindrome Permutation II generates the strings. This problem only asks whether one exists.\nStep back to when you built the list.",
            'outcome' => 'wrong',
            'rewind_to' => 'already',
            'choices' => [],
        ],
        'count' => [
            'message' => "Count 26. Add 1 for each odd (count AND 1). Return whether that sum is less than 2. Bit twin: flip bit c minus a; at most one bit stays set.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '"aab" true (one odd), "carerac" true, "code" false (four odds)', 'next' => 'cpx'],
                ['label' => 'Two odds are fine when the length is even', 'next' => 'wrong_two'],
            ],
        ],
        'wrong_two' => [
            'message' => "You are wrong. Even length still needs every count even. Two odds cannot sit on one center.\nStep back to when you allowed two odds.",
            'outcome' => 'wrong',
            'rewind_to' => 'count',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(1) for 26 letters. Valid Anagram compares two bags; here you test one bag.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'At most one odd count. Not “already a palindrome,” not generate, not II', 'next' => 'success'],
                ['label' => 'Valid Palindrome: two pointers on the original string, ignore rearranging', 'next' => 'wrong_vp'],
            ],
        ],
        'wrong_vp' => [
            'message' => "You are wrong. Valid Palindrome checks the given order. Here you may rearrange.\nStep back to when you forbade permuting.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Count letters. At most one odd. \"aab\" and \"carerac\" yes; \"code\" no. Bit mask is the same test. Do not require s to already be a palindrome, generate n!, or emit II’s list.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
