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
            'message' => "Problem: string of + and -. A move flips two consecutive ++ into --. Return every string after exactly one move, any order. ++++ → --++, +--+, ++--. Lone + → []. Length 1..500.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Recurse / minimax: can the first player force a win (Flip Game II)', 'next' => 'wrong_ii'],
                ['label' => 'Scan adjacent pairs; flip ++, copy, restore', 'next' => 'scan'],
            ],
        ],
        'wrong_ii' => [
            'message' => "You are wrong here.\nThis problem only lists the children of the current state. Flip Game II is the win/lose search.\nStep back to when you solved II instead.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'scan' => [
            'message' => "Walk i from 0 to n − 2. If s[i] and s[i+1] are both +, set both to -, append a copy, set them back to +. Overlapping windows all count: ++++ has three moves.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Flip non-adjacent pluses, or skip restore so later windows see --', 'next' => 'wrong_adj'],
                ['label' => 'O(n²) from n windows each copying O(n). Empty list if no ++', 'next' => 'cpx'],
            ],
        ],
        'wrong_adj' => [
            'message' => "You are wrong. Only two consecutive pluses. Restore after each copy so the original string is still there for the next i.\nStep back to when you flipped the wrong pair or forgot restore.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "A +- or -- window is not a move. Nim Game is a different heap game.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'One scan of ++ windows. Not Game II, not non-adjacent flips', 'next' => 'success'],
                ['label' => '++++ has one move because you may flip only once per string', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. Each starting index is a separate one-move child. Windows at 0, 1, and 2 all fire.\nStep back to when you collapsed the three results.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. List every one-move child: flip each ++ window, copy, restore. Not Flip Game II. O(n²).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
