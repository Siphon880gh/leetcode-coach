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
            'message' => "Problem: true if digit string num looks the same after a 180° rotate. Length 1..50. \"69\" and \"88\" → true. \"962\" → false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Palindrome Number: num[i] == num[j]; or Palindrome Permutation: at most one odd count', 'next' => 'pal'],
                ['label' => 'Map rotate of each digit; two pointers: d[left] must equal the right digit', 'next' => 'map'],
            ],
        ],
        'pal' => [
            'message' => "\"69\" is a palindrome of rotation, not of characters (6 ≠ 9). Letter-odd-counts is 266, a different predicate. Strobogrammatic Number II generates all such strings of length n.\nWhat is the pair map?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '0,1,8 stay; 6↔9; 2,3,4,5,7 are −1. i and j meet; fail if d[num[i]] ≠ num[j]', 'next' => 'map'],
                ['label' => 'Treat 2 as a rotate of 5', 'next' => 'wrong_25'],
            ],
        ],
        'wrong_25' => [
            'message' => "You are wrong here.\n2 and 5 do not look like digits after a 180° turn in this problem. They are invalid.\nStep back to when you allowed 2.",
            'outcome' => 'wrong',
            'rewind_to' => 'pal',
            'choices' => [],
        ],
        'map' => [
            'message' => "While i ≤ j: rotate of the left must equal the right, then i++, j−−. Odd length: the middle digit must map to itself, so only 0, 1, 8. \"6\" alone fails (rotates to 9). \"69\" matches.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '\"69\" and \"88\" true; \"962\" false; single \"6\" false', 'next' => 'cpx'],
                ['label' => 'Skip the middle on odd length, or accept \"6\" because 6 is in the map', 'next' => 'wrong_mid'],
            ],
        ],
        'wrong_mid' => [
            'message' => "You are wrong. The middle must still equal its own rotate. 6 maps to 9, so a lone 6 is false.\nStep back to when you skipped the center.",
            'outcome' => 'wrong',
            'rewind_to' => 'map',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n), space O(1). Not character palindrome, not odd-count permutation, not generate-all (II).\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Rotate map plus two pointers; middle maps to itself; not palindrome equality', 'next' => 'success'],
                ['label' => 'Generate every length-n strobogrammatic string, then search for num', 'next' => 'wrong_gen'],
            ],
        ],
        'wrong_gen' => [
            'message' => "You are wrong. That is Strobogrammatic Number II. This problem only tests one string in linear time.\nStep back to when you generated the family.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. d = [0,1,−1,−1,−1,−1,9,−1,8,6]. Two pointers: rotate of left equals right. Odd middle must be 0, 1, or 8. Not a character palindrome, not 266, not II.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
