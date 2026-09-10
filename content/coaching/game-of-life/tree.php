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
            'message' => "Problem: next generation of Conway’s Life, in place. Eight neighbors. Live dies unless 2 or 3 live neighbors; dead becomes live on exactly 3. All cells use the current generation together.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Write 0 or 1 as you scan; later cells read the new values', 'next' => 'wrong_write'],
                ['label' => 'Encode: 2 means live→dead, −1 means dead→live; then remap', 'next' => 'enc'],
            ],
        ],
        'wrong_write' => [
            'message' => "You are wrong here.\nBirths and deaths are simultaneous. A 0 written early changes a later neighbor count.\nStep back to when you overwrote with 0/1 during the count.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'enc' => [
            'message' => "Count live neighbors with board[x][y] > 0 (1 and 2 both were live). Subtract the center if the 3 by 3 window includes it (live starts at −board[i][j]). Live and live<2 or live>3 → 2. Dead and live==3 → −1. Second pass: 2→0, −1→1.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only four orthogonal neighbors, skip diagonals', 'next' => 'wrong_4'],
                ['label' => 'O(m n) time, O(1) extra. A copy of the board is correct but extra space', 'next' => 'cpx'],
            ],
        ],
        'wrong_4' => [
            'message' => "You are wrong. Life uses eight neighbors (Moore neighborhood), including diagonals.\nStep back to when you used 4-neighbors.",
            'outcome' => 'wrong',
            'rewind_to' => 'enc',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Void return: mutate board. Follow-up infinite board is a set of live cells, not this encoding.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '2 and −1 keep old live readable. Not 4-neighbors, not 0/1 mid-scan', 'next' => 'success'],
                ['label' => 'Skip subtracting the center; count the cell as its own neighbor', 'next' => 'wrong_self'],
            ],
        ],
        'wrong_self' => [
            'message' => "You are wrong. Neighbors do not include the cell itself. If you count the 3 by 3 window, start live at −board[i][j] (or skip the center).\nStep back to when you counted self.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Encode next state so > 0 still means originally live. Second pass maps 2→0 and −1→1. Eight neighbors, simultaneous. In place.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
