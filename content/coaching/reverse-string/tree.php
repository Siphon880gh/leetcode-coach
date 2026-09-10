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
            'message' => "Problem: reverse character array s in place. O(1) extra memory. hello → olleh. Hannah → hannaH. Length up to 1e5. Mutate s; return nothing.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Allocate a reversed copy, or reverse the words like Reverse Words in a String (151)', 'next' => 'wrong_copy'],
                ['label' => 'Two pointers: swap s[i] with s[j] until they meet', 'next' => 'swap'],
            ],
        ],
        'wrong_copy' => [
            'message' => "You are wrong here. A new array (or assigning a reversed copy) uses O(n) extra memory. 151 reverses tokens, not the raw character array.\nStep back to when you allocated a copy or reversed words.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'swap' => [
            'message' => "i = 0, j = n−1. While i < j, swap, then i += 1 and j −= 1. Odd length: the middle stays. Even length: every pair swaps.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only swap vowels (345), or reverse every 2k block (541)', 'next' => 'wrong_345'],
                ['label' => 'In-place two pointers. Time O(n), extra space O(1)', 'next' => 'cpx'],
            ],
        ],
        'wrong_345' => [
            'message' => "You are wrong. Reverse Vowels only swaps vowels. Reverse String II reverses every block of 2k. This problem reverses the whole array.\nStep back to when you treated this as 345 or 541.",
            'outcome' => 'wrong',
            'rewind_to' => 'swap',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Leave s mutated. Do not return a new string and leave the input unchanged.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Swap from both ends until they meet. O(1) extra', 'next' => 'success'],
                ['label' => 'Return the reversed string and leave s unchanged', 'next' => 'wrong_ret'],
            ],
        ],
        'wrong_ret' => [
            'message' => "You are wrong. The tester inspects s after the call. Returning a new string while leaving s as hello fails.\nStep back to when you returned a copy instead of mutating s.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Two pointers swap in place until they meet. Not a copy. Not 151, 345, or 541.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
