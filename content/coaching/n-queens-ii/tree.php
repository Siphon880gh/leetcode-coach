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
            'message' => "Problem: same n-queens attacks as LeetCode 51, but return how many distinct boards exist, not the boards. n=4 → 2. n=1 → 1. n ≤ 9.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Call N-Queens I, build every string board, then return the list length', 'next' => 'boards'],
                ['label' => 'Same row DFS and attack marks; when i==n, increment a counter and return', 'next' => 'dfs'],
            ],
        ],
        'boards' => [
            'message' => "The count matches, but each solution copies n strings. This problem only needs the integer.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hard-code the known counts for n = 1..9 and skip search', 'next' => 'wrong_table'],
                ['label' => 'Keep cols, dg (i+j), udg (i-j+n); no g[][] snapshot; ans++ at depth n', 'next' => 'dfs'],
            ],
        ],
        'wrong_table' => [
            'message' => "You are wrong here.\nA lookup table hides the search. Interviewers want the same prune as N-Queens I, then a counter.\nStep back to when you skipped the DFS.",
            'outcome' => 'wrong',
            'rewind_to' => 'boards',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Why still mark both diagonals if you never draw Q on a board?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Attacks are the same: a permutation of columns can still share i+j or i-j+n', 'next' => 'example'],
                ['label' => 'Counting does not need diagonal checks; unique columns already give distinct boards', 'next' => 'wrong_diag'],
            ],
        ],
        'wrong_diag' => [
            'message' => "You are wrong. n! column permutations include diagonal attacks. Those are not solutions, so the count would be too large.\nStep back to when you dropped diagonal marks.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'example' => [
            'message' => "Unmark after dfs(i+1). n=4 yields 2. Writeup time is O(n!) (no O(n²) board copy per leaf); extra space O(n).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The integer ans, not a list of Q/dot strings', 'next' => 'success'],
                ['label' => 'The list of boards; the judge only reads length', 'next' => 'wrong_return'],
            ],
        ],
        'wrong_return' => [
            'message' => "You are wrong. The signature is totalNQueens → int. Returning boards is N-Queens I.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs(row). Skip j if cols[j], dg[i+j], or udg[i-j+n]. Recurse, unmark. At i==n, ans++. Time O(n!), space O(n). Not N-Queens I string boards, and not a hardcoded table.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
