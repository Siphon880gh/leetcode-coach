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
            'message' => "Problem: fill every '.' so each row, column, and 3x3 box has digits 1-9 once. The board has exactly one solution. Modify in place.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only run Valid Sudoku on the given board and return', 'next' => 'valid'],
                ['label' => 'DFS the empty cells; try digits not used in that row, column, or box', 'next' => 'dfs'],
            ],
        ],
        'valid' => [
            'message' => "Valid Sudoku checks filled cells. Here you must write the missing digits. Search with the same row/col/box marks, then recurse.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Fill every empty cell with 1, then check the whole board once', 'next' => 'wrong_late'],
                ['label' => 'Collect empties t; seed marks from givens; dfs(k) tries v on t[k]', 'next' => 'dfs'],
            ],
        ],
        'wrong_late' => [
            'message' => "You are wrong here.\nChecking only after the board is full does not prune illegal prefixes. You test each candidate against row, column, and box before placing it.\nStep back to when you chose when to check.",
            'outcome' => 'wrong',
            'rewind_to' => 'valid',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Place v, recurse, then usually unmark. When dfs reaches k == len(t) (every empty filled), what do you do?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Set ok and return without undoing, so the board keeps this fill', 'next' => 'example'],
                ['label' => 'Always unmark after dfs so you can try the next digit', 'next' => 'wrong_undo'],
            ],
        ],
        'wrong_undo' => [
            'message' => "You are wrong. Unmarking after a complete success wipes the unique solution. If ok, return immediately and skip the undo.\nStep back to when you handled a finished fill.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'example' => [
            'message' => "Pre-mark givens so you never overwrite a printed digit. For each empty (i,j), try v in 0..8 if row[i][v], col[j][v], and block[i//3][j//3][v] are all false. One solution is guaranteed.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Exponential in the number of empties, with constraint pruning; board is 9x9', 'next' => 'success'],
                ['label' => 'O(1) like Valid Sudoku — one scan of 81 cells', 'next' => 'wrong_o1'],
            ],
        ],
        'wrong_o1' => [
            'message' => "You are wrong. Validation is one pass. Solving searches assignments. Pruning makes it fast on 9x9, but it is still backtracking.\nStep back to when you scored the search.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Seed row/col/box from givens. DFS empty cells. Try a free digit, recurse; on success keep the board, else undo. Time exponential in empties, space O(empties) for the stack.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
