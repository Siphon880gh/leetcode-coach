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
            'message' => "Problem: is a 9x9 board valid? Only filled cells count. Rows, columns, and each 3x3 box must have unique digits 1-9. Dots are empty. The board need not be solvable.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Backtrack to fill every dot and see if a solution exists', 'next' => 'solve'],
                ['label' => 'One pass: mark each filled digit in its row, column, and 3x3 box', 'next' => 'seen'],
            ],
        ],
        'solve' => [
            'message' => "That is Sudoku Solver. This problem only validates what is already written. A partial board can be valid and still unsolvable.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Check each row for unique digits; columns and boxes will follow', 'next' => 'wrong_row'],
                ['label' => 'Skip empty cells; if digit d already appeared in row i, col j, or box k, return false', 'next' => 'seen'],
            ],
        ],
        'wrong_row' => [
            'message' => "You are wrong here.\nExample 2 has unique digits in the first row, but two 8s share the top-left 3x3 box. Rows, columns, and boxes are three independent constraints.\nStep back to when you chose what to check.",
            'outcome' => 'wrong',
            'rewind_to' => 'solve',
            'choices' => [],
        ],
        'seen' => [
            'message' => "Boxes are numbered 0..8 left-to-right, top-to-bottom. For cell (i, j), which k?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'k = (i // 3) * 3 + (j // 3)', 'next' => 'example'],
                ['label' => 'k = (i % 3) * 3 + (j % 3) — the offset inside the box', 'next' => 'wrong_box'],
            ],
        ],
        'wrong_box' => [
            'message' => "You are wrong. i%3 and j%3 locate a cell inside a box, not which of the nine boxes you are in. (0,0) and (3,3) would get the same k.\nStep back to when you indexed the box.",
            'outcome' => 'wrong',
            'rewind_to' => 'seen',
            'choices' => [],
        ],
        'example' => [
            'message' => "Use three 9x9 boolean tables (or sets) row, col, sub. For each filled d, if row[i][d] or col[j][d] or sub[k][d] is already true, invalid; else mark them. Dots are skipped. A full board is not required.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(1) time and space — the board is always 9x9 (81 cells)', 'next' => 'success'],
                ['label' => 'O(9^n) because you still search for a completing assignment', 'next' => 'wrong_exp'],
            ],
        ],
        'wrong_exp' => [
            'message' => "You are wrong. Validation is one scan of 81 cells. Solving is a different problem.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Skip dots. Mark each digit in its row, column, and box k = (i//3)*3+(j//3). Duplicate seen → false. Time and space O(1) on a fixed 9x9.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
