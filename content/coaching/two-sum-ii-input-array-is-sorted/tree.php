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
            'message' => "Problem: numbers is sorted, 1-indexed. Return the two indices (already +1) that sum to target. Exactly one pair. Constant extra space. [2,7,11,15], target 9 → [1,2].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Two Sum I hash map, 3Sum triplets, or Fraction-to-decimal remainders', 'next' => 'hash'],
                ['label' => 'i at 0, j at n-1; move i up if the sum is small, j down if it is large', 'next' => 'ptr'],
            ],
        ],
        'hash' => [
            'message' => "A complement map is O(n) extra memory; this problem forbids that. 3Sum looks for three numbers. Remainders are for repeating decimals.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return 0-based indices like Two Sum I', 'next' => 'wrong_idx'],
                ['label' => 'Sorted order lets two pointers close in with O(1) extra space', 'next' => 'ptr'],
            ],
        ],
        'wrong_idx' => [
            'message' => "You are wrong here.\nThe judge wants 1-based positions. For [2,7,11,15] that is [1,2], not [0,1].\nStep back to when you reused Two Sum I’s indexing.",
            'outcome' => 'wrong',
            'rewind_to' => 'hash',
            'choices' => [],
        ],
        'ptr' => [
            'message' => "while i < j: x = numbers[i] + numbers[j]. Equal → return [i+1, j+1]. Too small → i += 1. Too big → j -= 1.\nOn [2,7,11,15] target 9, first x is 2+15=17. What next?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '17 > 9 so j moves left until 2+7; return [1,2]', 'next' => 'ans'],
                ['label' => 'Move i right because 17 is too big, or return [0,3]', 'next' => 'wrong_move'],
            ],
        ],
        'wrong_move' => [
            'message' => "You are wrong. A sum above target means the right value is too large, so shrink j, not grow i. And do not return 0-based [0,3].\nStep back to when 17 appeared.",
            'outcome' => 'wrong',
            'rewind_to' => 'ptr',
            'choices' => [],
        ],
        'ans' => [
            'message' => "[2,3,4] target 6 → [1,3] (2+4). [-1,0] target -1 → [1,2]. O(n) time, O(1) extra space. Not a hash map, not 3Sum.\nWhat is [2,3,4], target 6?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,3] — 2 and 4', 'next' => 'success'],
                ['label' => '[1,2] from the first sample, or [0,2] 0-based', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. 2+3 is 5, not 6. The pair is indices 1 and 3. Do not reuse [1,2].\nStep back to when you scored [2,3,4].",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Two pointers on the sorted array; return 1-based indices. Not Two Sum I’s map, not 3Sum, not 0-based. [2,7,11,15] target 9 → [1,2].\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
