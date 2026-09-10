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
            'message' => "Problem: each row sorted left to right, each column sorted top to bottom. The next row does not start after the previous row’s last cell. Return whether target is in the grid. 5 → true; 20 → false. m, n up to 300.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Search a 2D Matrix (74): flatten with mid / n, mid % n as one sorted stream', 'next' => 'flat'],
                ['label' => 'Start at bottom-left (or top-right): equal true; too big go up; too small go right', 'next' => 'stair'],
            ],
        ],
        'flat' => [
            'message' => "74 needs the whole matrix to be one increasing stream. Here matrix[0][last] can be larger than matrix[1][0], so that flatten is wrong. Per-row binary search is O(m log n) and correct.\nHow do you get O(m + n)?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'i = m−1, j = 0. While in bounds: equal → true; cell > target → i−1; else j+1. Fall off → false', 'next' => 'stair'],
                ['label' => 'Start at top-left: both right and down increase, so a miss still tells you which way to go', 'next' => 'wrong_tl'],
            ],
        ],
        'wrong_tl' => [
            'message' => "You are wrong here.\nFrom top-left both directions grow. A too-small cell does not discard a unique row or column. Bottom-left (or top-right) does.\nStep back to when you started at the top-left.",
            'outcome' => 'wrong',
            'rewind_to' => 'flat',
            'choices' => [],
        ],
        'stair' => [
            'message' => "Each step discards a row or a column. Symmetric start: top-right, then too big go left, too small go down. Sample: 5 is present, 20 is not.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '5 → true; 20 → false', 'next' => 'cpx'],
                ['label' => 'Scan every cell; O(m n) is required because there is no global order', 'next' => 'wrong_scan'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong. Rows and columns are still sorted, so a staircase (or per-row binary search) is enough. A full scan is correct but not the intended bound.\nStep back to when you required a full scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'stair',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(m + n) staircase, O(1) extra. Not 74’s flatten, not top-left, not a required full scan.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Corner staircase; not 74 flatten, not top-left, not full scan as required', 'next' => 'success'],
                ['label' => 'Treat it as Search Insert Position on a 1D copy of every cell', 'next' => 'wrong_copy'],
            ],
        ],
        'wrong_copy' => [
            'message' => "You are wrong. Flattening into one array loses the 2D sort and uses extra space. Stay on the grid.\nStep back to when you copied the matrix into one array.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Bottom-left (or top-right): equal → true; too big discard the row (or column); too small discard the other. O(m + n). Not 74, not top-left, not a required full scan.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
