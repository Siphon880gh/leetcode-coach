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
            'message' => "Problem: non-negative integer as a singly linked list, most significant digit at head. Plus one. Length 1..100, no leading zeros except 0 itself. [1,2,3] → [1,2,4]. [0] → [1]. [9,9] → [1,0,0].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Join digits into a machine int, add 1, rebuild the list', 'next' => 'wrong_int'],
                ['label' => 'Dummy 0 in front; remember the last node whose value is not 9', 'next' => 'dummy'],
            ],
        ],
        'wrong_int' => [
            'message' => "You are wrong here. A 100-digit number will not fit in a 64-bit int.\nStep back to when you packed the list into an integer.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dummy' => [
            'message' => "Walk from dummy. Each time you see a digit that is not 9, set target to that node (target starts as dummy). Then target.val += 1, and set every node after target to 0. If dummy.val is 1, every original digit was 9 — return dummy; else return dummy.next.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only bump the tail node (or treat this as 66: array from the end)', 'next' => 'wrong_tail'],
                ['label' => 'Carry dies at the last non-nine; the suffix of nines becomes zeros', 'next' => 'kind'],
            ],
        ],
        'wrong_tail' => [
            'message' => "You are wrong. [1,2,9] plus one is [1,3,0], not a 10 in the last node. 66 is the array version; here you cannot index from the end in O(1).\nStep back to when you mutated only the tail or treated this as 66.",
            'outcome' => 'wrong',
            'rewind_to' => 'dummy',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Add Two Numbers (2) stores the least significant digit at the head, so you add from the front. Here the head is the high digit. Reverse, add, reverse also works, but the dummy last-non-nine walk is one pass and O(1) extra besides a possible new head.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Dummy last-non-nine, increment, zero the suffix. Not 66. Not 2', 'next' => 'success'],
                ['label' => 'Walk from the head like 2, adding 1 to the first node', 'next' => 'wrong_lsd'],
            ],
        ],
        'wrong_lsd' => [
            'message' => "You are wrong. Adding at the head here bumps the high digit. [1,2,3] would become [2,2,3], not [1,2,4].\nStep back to when you treated this as problem 2.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Dummy 0, last non-nine gets plus one, suffix zeros. All nines return dummy as the new 1. [1,2,3] → [1,2,4]. Not 66. Not 2.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
