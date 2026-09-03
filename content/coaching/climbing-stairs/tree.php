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
            'message' => "Problem: n stairs; each move is 1 or 2 steps. Count distinct sequences. n=2 → 2. n=3 → 3. n ≤ 45.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DFS every 1/2 walk to n and increment a counter, no cache', 'next' => 'dfs'],
                ['label' => 'DP: f[i] = f[i-1] + f[i-2]; roll two variables in O(n) time, O(1) extra', 'next' => 'dp'],
            ],
        ],
        'dfs' => [
            'message' => "n up to 45. Branching without memo is exponential. Ways to reach i-1 are reused for later stairs.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy Unique Paths: a 2D grid, add from above and left', 'next' => 'wrong_grid'],
                ['label' => 'A 1D recurrence: last step was 1 (from i-1) or 2 (from i-2), so add those two counts', 'next' => 'dp'],
            ],
        ],
        'wrong_grid' => [
            'message' => "You are wrong here.\nUnique Paths is an m×n board with only down/right. This is a 1D stair count (Fibonacci).\nStep back to when you built a grid.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Why is 1 then 2 different from 2 then 1 when n=3?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The problem counts sequences of moves, not the multiset of step sizes', 'next' => 'roll'],
                ['label' => 'They are the same combination, so n=3 should be 2', 'next' => 'wrong_combo'],
            ],
        ],
        'wrong_combo' => [
            'message' => "You are wrong. Example 2 lists three ways: 1+1+1, 1+2, and 2+1. Order matters.\nStep back to when you collapsed the two mixed orders.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'roll' => [
            'message' => "Writeup rolls two ints: after n updates, return b. Time O(n), extra O(1). Seed so n=1 returns 1.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The number of ways f[n] — not a list of sequences, and not Unique Paths on a grid', 'next' => 'success'],
                ['label' => 'Every sequence of 1s and 2s; the judge needs the list', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. The signature returns an integer count.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'roll',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. f[i] = f[i-1] + f[i-2]. Roll two variables n times. Time O(n). 1D Fibonacci ways — not Unique Paths on a grid, and not DFS without memo.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
