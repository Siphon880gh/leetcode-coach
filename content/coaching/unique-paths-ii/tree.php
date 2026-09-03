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
            'message' => "Problem: same down/right count as Unique Paths, but grid 1s are obstacles you cannot enter. [[0,0,0],[0,1,0],[0,0,0]] → 2. [[0,1],[0,0]] → 1. m,n ≤ 100.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy Unique Paths I: f[0][0]=1 and add from up and left, ignore the 1s', 'next' => 'empty'],
                ['label' => 'Memo DFS: OOB or grid=1 → 0; at the end cell → 1; else dfs(down)+dfs(right)', 'next' => 'memo'],
            ],
        ],
        'empty' => [
            'message' => "The middle 1 in the 3×3 example blocks both the center cell and any path that would use it. Unique Paths I would still count 6.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A 1 means “one extra path through this cell”', 'next' => 'wrong_one'],
                ['label' => 'If obstacleGrid[i][j] is 1 (or you walked off the board), that state contributes 0 ways', 'next' => 'memo'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong here.\nIn this grid, 1 is a wall and 0 is open. Adding 1 as if it were a path count is Unique Paths I plus noise.\nStep back to when you misread the 1s.",
            'outcome' => 'wrong',
            'rewind_to' => 'empty',
            'choices' => [],
        ],
        'memo' => [
            'message' => "Check the obstacle before treating (m-1,n-1) as a success. Why?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'If the finish cell itself is 1, there are 0 paths, even though you “arrived”', 'next' => 'example'],
                ['label' => 'The start is never blocked; you can always leave (0,0)', 'next' => 'wrong_start'],
            ],
        ],
        'wrong_start' => [
            'message' => "You are wrong. If grid[0][0] is 1, dfs returns 0 immediately. Same for the finish cell.\nStep back to when you assumed the start was open.",
            'outcome' => 'wrong',
            'rewind_to' => 'memo',
            'choices' => [],
        ],
        'example' => [
            'message' => "Cache dfs(i,j) so each cell is solved once. Without cache the tree is exponential. 3×3 with a center wall → 2.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(m·n) time and O(m·n) extra with memoization', 'next' => 'success'],
                ['label' => 'O(2^{m+n}) is required because every path must be listed', 'next' => 'wrong_exp'],
            ],
        ],
        'wrong_exp' => [
            'message' => "You are wrong. Memoization collapses overlapping subproblems to one visit per cell. Listing paths is not required.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs(i,j): 0 if off-board or grid is 1; 1 at the open finish; else down + right, memoized. Time O(m·n). Obstacles — not Unique Paths I on an empty grid, and not treating 1 as a path count.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
