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
            'message' => "Problem: binary matrix of 0/1; largest rectangle of only 1s, return area. Example → 6. rows, cols ≤ 200.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count paths like Unique Paths, or flatten like Search a 2D Matrix', 'next' => 'paths'],
                ['label' => 'Each row is a histogram base: heights[j] += 1 on 1, else 0; then Largest Rectangle in Histogram', 'next' => 'hist'],
            ],
        ],
        'paths' => [
            'message' => "Unique Paths counts routes. The 2D-matrix flatten needs fully sorted rows. Here you want a solid block of 1s, which is a histogram sitting on each row as the floor.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Set Matrix Zeroes: mark rows and cols, then zero them', 'next' => 'wrong_zero'],
                ['label' => 'Build heights from consecutive 1s upward, then monotonic-stack area per row', 'next' => 'hist'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong here.\nSet Matrix Zeroes writes 0s from original zeros. This problem never mutates the grid that way; it measures 1-rectangles.\nStep back to when you reused Set Matrix Zeroes.",
            'outcome' => 'wrong',
            'rewind_to' => 'paths',
            'choices' => [],
        ],
        'hist' => [
            'message' => "If the cell is 0, heights[j] = 0, not leave the old streak. Why reset?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A 0 breaks the column; the histogram bar cannot stand on a 0 floor', 'next' => 'area'],
                ['label' => 'Keep adding; 0s are walls like Unique Paths II but the bar still grows', 'next' => 'wrong_keep'],
            ],
        ],
        'wrong_keep' => [
            'message' => "You are wrong. Unique Paths II’s 1 is a blocked cell for routing. Here 0 means this column’s height from the current row is zero.\nStep back to when you kept the streak across a 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'hist',
            'choices' => [],
        ],
        'area' => [
            'message' => "After each row, ans = max(ans, largestRectangleArea(heights)). Time O(m·n). [[0]] → 0, [[1]] → 1.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The max area over all row-histograms — an integer, not the 1D-only histogram problem’s input', 'next' => 'success'],
                ['label' => 'The matrix itself, like Rotate Image in place', 'next' => 'wrong_rot'],
            ],
        ],
        'wrong_rot' => [
            'message' => "You are wrong. Rotate Image permutes cells. This signature returns an area.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'area',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. For each row, grow heights on 1 and reset on 0, then run Largest Rectangle in Histogram. Max over rows. O(m·n). Not Unique Paths, not a sorted-matrix flatten, not Set Matrix Zeroes, not 84 alone on a 1D input.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
