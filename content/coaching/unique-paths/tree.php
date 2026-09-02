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
            'message' => "Problem: m×n empty grid. Start at (0,0), end at (m-1,n-1), only down or right. Count routes. 3×7 → 28. 3×2 → 3. m,n ≤ 100.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DFS every down/right walk and increment a counter', 'next' => 'dfs'],
                ['label' => 'DP: f[0][0]=1; f[i][j] += f[i-1][j] if i>0 and f[i][j-1] if j>0', 'next' => 'dp'],
            ],
        ],
        'dfs' => [
            'message' => "m,n up to 100. Recursing both branches is exponential. Unique Paths II also has stones; this grid is empty.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip cells that look blocked even though there are no obstacles', 'next' => 'wrong_obs'],
                ['label' => 'f[i][j] = ways through the cell above plus ways through the cell to the left', 'next' => 'dp'],
            ],
        ],
        'wrong_obs' => [
            'message' => "You are wrong here.\nObstacle skipping is Unique Paths II. Here every cell is open; you only add from up and left.\nStep back to when you invented walls.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Why add the two parents instead of multiplying them?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A path arrives from exactly one neighbor; the two incoming sets are disjoint, so add', 'next' => 'example'],
                ['label' => 'You must come from both up and left on every path, so multiply', 'next' => 'wrong_mul'],
            ],
        ],
        'wrong_mul' => [
            'message' => "You are wrong. One path is a sequence of downs and rights. It last stepped from either above or left, never both at once.\nStep back to when you multiplied.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'example' => [
            'message' => "Seed f[0][0]=1 so the first row and column fill by a single add. 3×2 yields 3. Writeup time O(m·n); space O(m·n), or O(n) if you roll the row.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'f[m-1][n-1], the number of paths — not a list of moves', 'next' => 'success'],
                ['label' => 'Every coordinate sequence; the judge only needs the count so listing is required', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. The signature returns an integer. Listing paths is DFS again and too large.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. f[0][0]=1. For each cell, add from above if i>0 and from left if j>0. Answer f[m-1][n-1]. Time O(m·n). Empty grid, down/right only — not Unique Paths II, and not DFS of every walk.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
