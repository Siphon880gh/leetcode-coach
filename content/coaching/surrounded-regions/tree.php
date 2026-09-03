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
            'message' => "Problem: capture every O-region that does not touch the border (flip those O’s to X, in place). An O on the edge stays. Sample: inner O’s become X; the bottom-edge O remains.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Flip every O, Number of Islands’ count, Word Search’s word DFS, or Set Matrix Zeroes’ row marks', 'next' => 'flip'],
                ['label' => 'DFS from every border O, mark the unsurrounded component, then flip the leftover O’s', 'next' => 'dfs'],
            ],
        ],
        'flip' => [
            'message' => "Flipping every O would capture the border too. Islands counts components. Word Search hunts a string. Zeroes marks rows, not O-regions.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Word Ladder’s letter swaps, or return a new board instead of editing in place', 'next' => 'wrong_other'],
                ['label' => 'Paint border-connected O’s as a temp mark; remaining O → X; restore the mark to O', 'next' => 'dfs'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nThis is a grid flood-fill from the rim, void, in place. Not a word graph and not a copied matrix.\nStep back to when you copied those APIs.",
            'outcome' => 'wrong',
            'rewind_to' => 'flip',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "dfs only walks cells that are still O. Mark them '.' then recurse 4-way. After the border pass, '.' → O and leftover O → X. Time O(m·n).\nWhy start on the border instead of the interior?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Anything that can reach the edge is not surrounded; the interior leftover is exactly the captured set', 'next' => 'ret'],
                ['label' => 'Start DFS on every interior O and stop if you ever hit the edge', 'next' => 'wrong_inside'],
            ],
        ],
        'wrong_inside' => [
            'message' => "You are wrong. Searching from the inside works but you must not flip a region that later touches the rim. Marking from the border first is the safe one-pass capture.\nStep back to when you started in the interior.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "The function is void. Mutate board. Do not return it.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Nothing: board is updated in place. Not an island count, not a copied grid', 'next' => 'success'],
                ['label' => 'The new board as a return value, or the number of captured regions', 'next' => 'wrong_ret'],
            ],
        ],
        'wrong_ret' => [
            'message' => "You are wrong. The judge reads the same board. There is no return value and no count.\nStep back to when you returned a copy or a number.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Border DFS marks unsurrounded O’s, then leftover O → X. In place, void. O(m·n). Not flip-all, not Number of Islands, not Word Search, not Word Ladder, not Set Matrix Zeroes.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
