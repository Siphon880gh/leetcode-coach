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
            'message' => "Problem: does word exist as a path of up/down/left/right cells, no cell twice? [[A,B,C,E],[S,F,C,S],[A,D,E,E]], \"ABCCED\" → true, \"ABCB\" → false. m,n ≤ 6.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count paths like Unique Paths, or fill empty cells like Sudoku Solver', 'next' => 'paths'],
                ['label' => 'From every cell, dfs(i,j,k): match word[k], mark used, try 4 neighbors for k+1, unmark', 'next' => 'dfs'],
            ],
        ],
        'paths' => [
            'message' => "Unique Paths counts empty-grid routes. Sudoku fills digits. Here you match a given string on a letter grid and must not reuse a cell.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Allow diagonals, or reuse a cell so "ABCB" becomes true', 'next' => 'wrong_reuse'],
                ['label' => 'Try each start; mark the cell (writeup uses "0"), recurse four ways, restore on the way back', 'next' => 'dfs'],
            ],
        ],
        'wrong_reuse' => [
            'message' => "You are wrong here.\nExample 3 is false: after A-B-C the first B is already used. Adjacent means 4-neighbors, not diagonals.\nStep back to when you reused a cell or went diagonal.",
            'outcome' => 'wrong',
            'rewind_to' => 'paths',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "If k is the last index, return board[i][j] == word[k]. If the cell mismatches word[k], return false. Why write \"0\" then put the letter back?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The mark blocks reuse on this path; restore so later starts still see the original letter', 'next' => 'bool'],
                ['label' => 'Leave "0" forever; later starts should treat used cells as walls like Unique Paths II', 'next' => 'wrong_wall'],
            ],
        ],
        'wrong_wall' => [
            'message' => "You are wrong. Each start is an independent search. Unique Paths II’s 1s are permanent obstacles, not a DFS mark.\nStep back to when you left the board mutated.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'bool' => [
            'message' => "Time O(m·n·3^k) (after the first step, three unused directions). Space O(min(m·n, k)).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'true if any start’s dfs(i,j,0) succeeds, else false — a boolean, not the path string', 'next' => 'success'],
                ['label' => 'The matching path, or every word like Word Search II', 'next' => 'wrong_ii'],
            ],
        ],
        'wrong_ii' => [
            'message' => "You are wrong. This signature is boolean for one word. Word Search II returns a list of words with a trie.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'bool',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Enumerate starts. dfs(i,j,k) matches word[k], marks the cell, tries 4-neighbors for k+1, restores. Same cell once; no diagonals. Boolean, not Unique Paths, not Sudoku, not Word Search II. Time O(m·n·3^k).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
