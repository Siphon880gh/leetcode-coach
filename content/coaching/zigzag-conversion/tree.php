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
            'message' => "Problem: s = \"PAYPALISHIRING\", numRows = 3. Write the string in a zigzag and read it row by row → \"PAHNAPLSIIGYIR\".\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Build a full 2D grid of spaces, then scan every cell', 'next' => 'grid'],
                ['label' => 'Keep numRows lists and bounce a row index down and up', 'next' => 'bounce'],
            ],
        ],
        'grid' => [
            'message' => "A full grid works, but most cells are empty. You only need the characters that actually land on each row.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Transpose the original string as if it were a matrix', 'next' => 'wrong_transpose'],
                ['label' => 'Append each character to g[i], then move i by a direction that flips at the edges', 'next' => 'bounce'],
            ],
        ],
        'wrong_transpose' => [
            'message' => "You are wrong here.\nThe input is a 1-D string, not a filled matrix. Zigzag is a walk that goes down the rows then diagonally up.\nStep back to when you chose how to place characters.",
            'outcome' => 'wrong',
            'rewind_to' => 'grid',
            'choices' => [],
        ],
        'bounce' => [
            'message' => "Place a character on row i, then if i is 0 or numRows−1 reverse direction k, then i += k.\nWhy initialize k = −1 before the first character?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Row 0 is an edge, so the first place flips k to +1 and you walk down', 'next' => 'one_row'],
                ['label' => 'k = −1 means the first character goes to row −1', 'next' => 'wrong_neg'],
            ],
        ],
        'wrong_neg' => [
            'message' => "You are wrong. You append first, then flip, then add k. The first character sits on row 0; the flip makes k = +1 so the next one goes to row 1.\nStep back to when you set the initial direction.",
            'outcome' => 'wrong',
            'rewind_to' => 'bounce',
            'choices' => [],
        ],
        'one_row' => [
            'message' => "numRows = 1, s = \"A\". If you still bounce between 0 and 0, k flips every character and i never leaves 0 — unless you forget the early return and divide by a cycle of 0.\nWhat should convert return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 's unchanged — one row is already the zigzag', 'next' => 'join'],
                ['label' => 'The reverse of s, because the walk immediately turns around', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. With one row there is no zigzag. Return s (the solution’s first guard).\nStep back to when you handled numRows = 1.",
            'outcome' => 'wrong',
            'rewind_to' => 'one_row',
            'choices' => [],
        ],
        'join' => [
            'message' => "After the walk, concatenate g[0] + g[1] + … + g[numRows−1]. For 4 rows the answer is \"PINALSIGYAHRPI\".\nHow do you finish?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Join the row lists in order — that is reading line by line', 'next' => 'success'],
                ['label' => 'Join by column so the zigzag is undone back to s', 'next' => 'wrong_cols'],
            ],
        ],
        'wrong_cols' => [
            'message' => "You are wrong. The problem asks you to read the zigzag row by row, not to recover the original order.\nStep back to when you concatenated the rows.",
            'outcome' => 'wrong',
            'rewind_to' => 'join',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Simulate with numRows buckets, bounce at the top and bottom edges, then join rows. Time O(n), space O(n). Special-case numRows = 1.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
