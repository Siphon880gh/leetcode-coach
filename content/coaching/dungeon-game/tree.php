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
            'message' => "Problem: knight top-left, princess bottom-right, only right or down. Health must stay at least 1 after every room. Return min initial health. [[-2,-3,3],[-5,-10,1],[10,30,-5]] → 7. [[0]] → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Forward min path sum, Unique Paths counting, or greedy skip of −10', 'next' => 'fwd'],
                ['label' => 'DP from the princess: min HP needed before this room so you can still finish', 'next' => 'dp'],
            ],
        ],
        'fwd' => [
            'message' => "Min path sum adds costs from the start; a later heal cannot undo dying at 0 on the way. Unique Paths counts routes. Greedy “avoid −10” is not min start HP.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Take the max-sum path so heals cancel demons', 'next' => 'wrong_max'],
                ['label' => 'Fill backward: max(1, min(right, down) minus this room)', 'next' => 'dp'],
            ],
        ],
        'wrong_max' => [
            'message' => "You are wrong here.\nA big heal after a 0 still leaves you dead. You need the start HP that never drops below 1, not the largest sum.\nStep back to when you maximized the path sum.",
            'outcome' => 'wrong',
            'rewind_to' => 'fwd',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Dummy cells past the last row and column hold 1 so leaving the princess with 1 is enough. Clamp with max(1, …) so leftover heal never lets you start at 0.\nWhat is [[0]]?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '1 — you still need 1 HP before a 0 room', 'next' => 'ans'],
                ['label' => '0 because the room does not hurt', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. Health 0 is death. A 0 room still needs 1 going in.\nStep back to when you scored [[0]].",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'ans' => [
            'message' => "Answer is dp[0][0]. Sample path right, right, down, down needs 7. Time O(m n).\nWhat is the 3 by 3 sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '7', 'next' => 'success'],
                ['label' => '1 like [[0]], or the path sum of the cells', 'next' => 'wrong_seven'],
            ],
        ],
        'wrong_seven' => [
            'message' => "You are wrong. The sample’s min start HP is 7, not 1 and not the sum of the rooms.\nStep back to when you scored the 3 by 3 grid.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Backward DP; clamp at 1; answer dp[0][0]. Not min path sum, not Unique Paths, not greedy −10. [[0]] → 1. Sample → 7.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
