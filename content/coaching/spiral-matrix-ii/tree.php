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
            'message' => "Problem: build an n×n matrix filled 1..n² in clockwise spiral. n=3 → [[1,2,3],[8,9,4],[7,6,5]]. n=1 → [[1]]. n ≤ 20.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Fill 1..n² in row-major order, then read it with Spiral Matrix I', 'next' => 'read'],
                ['label' => 'Zero grid; write v=1..n² with dirs; turn if next is OOB or already nonzero', 'next' => 'fill'],
            ],
        ],
        'read' => [
            'message' => "Spiral Matrix I emits a list from an existing grid. Here the output is the grid, and row-major 1..9 is not the n=3 answer (center should be 9, bottom-right 5).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy Rotate Image: reverse rows and transpose until numbers line up', 'next' => 'wrong_rotate'],
                ['label' => 'Same heading as 54, but write v into ans[i][j]; occupied means ans[x][y] != 0', 'next' => 'fill'],
            ],
        ],
        'wrong_rotate' => [
            'message' => "You are wrong here.\nRotate Image turns an existing square. It does not place 1..n² in spiral order.\nStep back to when you reused rotate.",
            'outcome' => 'wrong',
            'rewind_to' => 'read',
            'choices' => [],
        ],
        'fill' => [
            'message' => "Why is a separate vis grid unnecessary?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Zeros mean empty; a filled cell is already nonzero, which is the same signal as vis', 'next' => 'example'],
                ['label' => 'You still need vis; writing a number does not record that the cell was visited', 'next' => 'wrong_vis'],
            ],
        ],
        'wrong_vis' => [
            'message' => "You are wrong. After ans[i][j] = v the cell is nonzero. Peeking ans[x][y] is enough to turn inward.\nStep back to when you allocated vis.",
            'outcome' => 'wrong',
            'rewind_to' => 'fill',
            'choices' => [],
        ],
        'example' => [
            'message' => "Loop v from 1 to n²: write, peek, maybe k = (k+1)%4, then step. n=3 center is 9. Extra space besides ans is O(1) in the writeup.\nWhat is the time?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n²): every cell is written once', 'next' => 'success'],
                ['label' => 'O(n): only the outer ring is filled; the inside stays 0', 'next' => 'wrong_ring'],
            ],
        ],
        'wrong_ring' => [
            'message' => "You are wrong. n=3 writes nine values including the center 9. Time is quadratic in n.\nStep back to when you scored only the border.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dirs right/down/left/up. Write 1..n². Turn when the next cell is out of bounds or nonzero. Time O(n²). Generate the board — not Spiral Matrix I on a row-major grid, and not Rotate Image.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
