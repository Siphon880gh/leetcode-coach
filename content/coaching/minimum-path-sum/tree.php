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
            'message' => "Problem: m×n grid of non-negative numbers. Start at (0,0), end at (m-1,n-1), only down or right. Minimize the sum of cells on the path. [[1,3,1],[1,5,1],[4,2,1]] → 7. m,n ≤ 200.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy Unique Paths: f[0][0]=1 and add ways from above and left', 'next' => 'count'],
                ['label' => 'DP: f[0][0]=grid[0][0]; first row/col are prefix sums; else min(up, left) + grid[i][j]', 'next' => 'dp'],
            ],
        ],
        'count' => [
            'message' => "Unique Paths counts routes. Here every cell has a cost, and the judge wants the cheapest total, not how many walks exist.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep adding the two parents; the sum of ways is the min cost', 'next' => 'wrong_add'],
                ['label' => 'Take the cheaper parent cost, then add this cell', 'next' => 'dp'],
            ],
        ],
        'wrong_add' => [
            'message' => "You are wrong here.\nAdding incoming ways is Unique Paths. Min path sum uses min of the two incoming costs, then plus grid[i][j].\nStep back to when you counted instead of minimizing.",
            'outcome' => 'wrong',
            'rewind_to' => 'count',
            'choices' => [],
        ],
        'dp' => [
            'message' => "At each interior cell, why min(f[i-1][j], f[i][j-1]) instead of greedily stepping to the cheaper of down vs right from the current cell?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A locally cheap next cell can sit on an expensive path; DP already stores the best cost to each neighbor', 'next' => 'example'],
                ['label' => 'Always pick the smaller of grid[i+1][j] and grid[i][j+1]; looking ahead is unnecessary', 'next' => 'wrong_greedy'],
            ],
        ],
        'wrong_greedy' => [
            'message' => "You are wrong. From the start of [[1,3,1],[1,5,1],[4,2,1]], greedy takes down (1 vs 3) and can finish at 9. The min path is 1→3→1→1→1 = 7.\nStep back to when you trusted a local step.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'example' => [
            'message' => "Seed the first row and first column with only one parent so you never min against a missing neighbor. Answer f[m-1][n-1]. Writeup time O(m·n), space O(m·n).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The min sum f[m-1][n-1] — not a list of cells, and not a path count', 'next' => 'success'],
                ['label' => 'The number of cheapest paths, like Unique Paths', 'next' => 'wrong_count'],
            ],
        ],
        'wrong_count' => [
            'message' => "You are wrong. The signature returns the minimum sum. Unique Paths / Unique Paths II return a count.\nStep back to when you chose the return value.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. f[0][0]=grid[0][0]. First row and column are prefix sums. Interior: min(up, left) + cell. Answer f[m-1][n-1]. Time O(m·n). Min cost — not Unique Paths counting, and not greedy next-cell picks.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
