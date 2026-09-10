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
            'message' => "Problem: binary grid, 1 is a home. Min total Manhattan travel to one meeting cell (empty cells allowed). Sample three homes at (0,0), (0,4), (2,2) → 6 at (0,2). [[1,1]] → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'BFS from every cell, or meet at the mean / centroid', 'next' => 'wrong_bfs'],
                ['label' => 'L1 splits: median row plus median column', 'next' => 'med'],
            ],
        ],
        'wrong_bfs' => [
            'message' => "You are wrong here.\nBFS from every cell is O((m n)²). The mean minimizes squared (L2) error, not Manhattan.\nStep back to when you used BFS or the centroid.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'med' => [
            'message' => "Row-major scan: append each home row (already sorted) and column (unsorted). Sort columns. k homes → meet at rows[k/2] and cols[k/2]. Sum abs(v − median) on each list.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip sorting columns; treat the scan order as sorted cols', 'next' => 'wrong_sort'],
                ['label' => 'O(m n + k log k). Rows are already ordered by the scan', 'next' => 'cpx'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong. Columns arrive in row-major order, not sorted by j. Sort cols before taking the median.\nStep back to when you skipped the column sort.",
            'outcome' => 'wrong',
            'rewind_to' => 'med',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Meeting on a 0 cell is allowed. Two homes on a 1 by 2 grid: median either home, total 1.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Median of rows and of columns. Not centroid, not all-cell BFS', 'next' => 'success'],
                ['label' => 'Must meet on a 1; empty cells are illegal', 'next' => 'wrong_empty'],
            ],
        ],
        'wrong_empty' => [
            'message' => "You are wrong. The meeting point may be any cell, including 0.\nStep back to when you banned empty cells.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Manhattan splits. Median row and median column. Sort columns. Sum absolute deviations. Not the centroid, not BFS from every cell.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
