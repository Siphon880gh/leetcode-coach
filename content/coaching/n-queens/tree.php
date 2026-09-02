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
            'message' => "Problem: place n queens on n×n so none attack. Return all boards as strings of Q and dots. n=4 → two solutions. n=1 → [[\"Q\"]]. n ≤ 9.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy Sudoku solver: try Q or dot in every cell, then validate the full board', 'next' => 'sudoku'],
                ['label' => 'DFS by row i: try column j if col, main diag, and anti-diag are free; record when i==n', 'next' => 'dfs'],
            ],
        ],
        'sudoku' => [
            'message' => "A queen occupies a whole row. You only need one placement per row, not a binary choice on every square.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Place n queens at random cells then reject attacks at the end', 'next' => 'wrong_late'],
                ['label' => 'dfs(i): for each free j, set g[i][j]=Q and mark col[j], dg[i+j], udg[n-i+j]', 'next' => 'dfs'],
            ],
        ],
        'wrong_late' => [
            'message' => "You are wrong here.\nWaiting until n queens sit on the board wastes work. Prune as soon as a column or diagonal is taken.\nStep back to when you delayed checks.",
            'outcome' => 'wrong',
            'rewind_to' => 'sudoku',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Why three marks, not just col[j]? Rows are already unique because you place exactly one queen in row i.",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Queens also attack diagonals: i+j and n-i+j (or i-j+n) identify those two families', 'next' => 'example'],
                ['label' => 'Columns suffice; diagonal attacks cannot happen if rows and columns are unique', 'next' => 'wrong_diag'],
            ],
        ],
        'wrong_diag' => [
            'message' => "You are wrong. Distinct rows and columns is a permutation of columns. Many permutations still share a diagonal (e.g. queens at (0,0) and (1,1)).\nStep back to when you dropped diagonal marks.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'example' => [
            'message' => "When i==n, join each row into a string and append a copy (N-Queens II only counts). Unmark and restore dots after the recursive call. n=4 yields two boards.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n² · n!) time in the writeup bound; O(n) extra for marks and the board', 'next' => 'success'],
                ['label' => 'O(n) because you walk n rows once', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. Each row branches over remaining columns. Copying a board is O(n²). The search is factorial, not linear.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs(row). Skip a column if col, i+j, or n-i+j is taken. Place Q, recurse, unmark. Snapshot string rows at depth n. Time about O(n² · n!). Not Sudoku cell-fill, and not a count-only answer.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
