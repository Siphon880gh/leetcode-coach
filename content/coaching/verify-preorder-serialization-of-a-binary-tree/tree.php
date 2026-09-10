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
            'message' => "Problem: comma-separated preorder; # is null. Do not rebuild the tree. “9,3,4,#,#,1,#,#,2,#,6,#,#” → true. “1,#” → false. “9,#,#,1” → false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Allocate TreeNode objects, or accept a node with only one child', 'next' => 'wrong_rebuild'],
                ['label' => 'Push tokens; replace value, #, # on top with one #', 'next' => 'stack'],
            ],
        ],
        'wrong_rebuild' => [
            'message' => "You are wrong here. The problem forbids reconstructing the tree. In this encoding every value has two children (possibly #). “1,#” is incomplete.\nStep back to when you allocated nodes or treated unary children as valid.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'stack' => [
            'message' => "A finished leaf is a value plus two nulls, so those three tokens act like one # to the parent. After every push, while the top three are (non-#, #, #), pop them and push #. At the end the stack must be a single #. Empty “#” is valid.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reject “#” as empty, or ignore leftover tokens after the tree is already complete', 'next' => 'wrong_empty'],
                ['label' => 'Same idea with vacancies: start 1; # spends 1; a number spends 1 and adds 2', 'next' => 'slots'],
            ],
        ],
        'wrong_empty' => [
            'message' => "You are wrong. One null is a valid empty tree. “9,#,#,1” has leftover tokens after the first tree finished, so it is false.\nStep back to when you rejected empty or skipped leftover tokens.",
            'outcome' => 'wrong',
            'rewind_to' => 'stack',
            'choices' => [],
        ],
        'slots' => [
            'message' => "Vacancy must stay non-negative and finish at 0 with every token consumed. O(n) time; stack O(n) or O(1) extra besides the split.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Collapse leaves to #. Vacancy ends at 0. Not reconstruct', 'next' => 'success'],
                ['label' => 'Only compare how many numbers vs hashes, ignoring order', 'next' => 'wrong_count'],
            ],
        ],
        'wrong_count' => [
            'message' => "You are wrong. Counts ignore order: tokens after a finished tree still fail even when the totals look close.\nStep back to when you counted nodes vs nulls without the stack or vacancy walk.",
            'outcome' => 'wrong',
            'rewind_to' => 'slots',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Collapse value, #, # into one # (or vacancy slots). End as a single #. Do not rebuild the tree.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
