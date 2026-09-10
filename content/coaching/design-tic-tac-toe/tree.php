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
            'message' => "Problem: TicTacToe(n), then move(row, col, player) on an n by n board. Moves are valid and unique. Return 0, 1, or 2. n from 2 to 100. Sample 3 by 3: last move (2,1) by player 1 fills the bottom row → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Scan all n² cells after every move, or treat this as Valid Tic-Tac-Toe State (794)', 'next' => 'wrong_scan'],
                ['label' => 'Count that player on the touched row, column, and at most two diagonals', 'next' => 'cnt'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong here. Follow-up wants better than a full-board scan. 794 asks whether a board could arise, not who just won.\nStep back to when you rescanned the board or reused 794.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'cnt' => [
            'message' => "Per player: n row counts, n column counts, main diagonal (row == col), anti-diagonal (row + col == n−1). On a move, increment those (at most four). If any equals n, return player; else 0.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Bump both diagonals on every cell, or require a draw check when the board fills', 'next' => 'wrong_diag'],
                ['label' => 'Only the matching diagonal(s). Signed trick: +1 vs −1, win when abs hits n', 'next' => 'cpx'],
            ],
        ],
        'wrong_diag' => [
            'message' => "You are wrong. Corner (0, n−1) is anti-diagonal only. The problem does not ask you to detect a draw — return 0 until someone hits n.\nStep back to when you always touched both diagonals or waited for a draw.",
            'outcome' => 'wrong',
            'rewind_to' => 'cnt',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Find Winner on a Tic Tac Toe Game (1275) is the same counting idea on a fixed 3 by 3 with a move list. Time O(1) per move. Space O(n).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count lines. O(1) per move. Not a full scan, not 794', 'next' => 'success'],
                ['label' => 'Store the whole board and rescan the moved row, column, and both diagonals in O(n)', 'next' => 'wrong_on'],
            ],
        ],
        'wrong_on' => [
            'message' => "You are wrong. O(n) per move works but misses the O(1) follow-up. Counters already know if a line hit n.\nStep back to when you rescanned a line.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Count the touched row, column, and matching diagonal(s). Win when a counter hits n. O(1) per move. Not a board scan, not 794.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
