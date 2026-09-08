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
            'message' => "Problem: m by n grid of '0'/'1'. Return the area of the largest all-1s square (not the side). First sample → 4. [[0,1],[1,0]] → 1. [[0]] → 0. Up to 300 by 300.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Number of Islands flood-fill, or Maximal Rectangle histograms (non-square OK)', 'next' => 'rect'],
                ['label' => 'DP: if cell is 1, side = 1 plus min(above, left, up-left). Return mx times mx', 'next' => 'dp'],
            ],
        ],
        'rect' => [
            'message' => "Islands count 4-connected blobs, any shape. 85 allows a wide rectangle that is not a square. Brute every top-left and side times out at 300.\nWhat is the square recurrence?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Pad a zero border. On a 1, take min of three neighbors plus one. Track max side, return area', 'next' => 'dp'],
                ['label' => 'Return the max side length, not the area', 'next' => 'wrong_side'],
            ],
        ],
        'wrong_side' => [
            'message' => "You are wrong here.\nThe judge wants mx times mx (area). Returning mx fails the first sample (2 vs 4).\nStep back to when you returned the side.",
            'outcome' => 'wrong',
            'rewind_to' => 'rect',
            'choices' => [],
        ],
        'dp' => [
            'message' => "dp[i+1][j+1] is the largest side ending at (i, j). Zero if the cell is '0'. Cells are characters — compare to '1', not integer 1. Rolling one previous row is enough.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'First sample area 4; [["0","1"],["1","0"]] → 1; [["0"]] → 0', 'next' => 'cpx'],
                ['label' => 'Treat the grid as ints so 1 and "1" are interchangeable without a check', 'next' => 'wrong_char'],
            ],
        ],
        'wrong_char' => [
            'message' => "You are wrong. The matrix is characters '0' and '1'. Integer 1 is not the same check.\nStep back to when you skipped the character test.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(m n) time. O(m n) table or O(n) rolling. Area, not side. Must be square.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Min of three plus one, then square the max side; not islands, not 85 histograms, not return side', 'next' => 'success'],
                ['label' => 'Any all-1s rectangle counts, so a 1 by 3 strip has area 3', 'next' => 'wrong_rect'],
            ],
        ],
        'wrong_rect' => [
            'message' => "You are wrong. The shape must be a square. A 1 by 3 strip is side 1, area 1.\nStep back to when you allowed non-squares.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Square DP: min of above, left, up-left, plus one. Return mx times mx. Characters. O(m n). Not islands, not Maximal Rectangle, not returning the side.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
