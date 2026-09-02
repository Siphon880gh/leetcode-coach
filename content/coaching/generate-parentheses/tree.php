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
            'message' => "Problem: generate parentheses. n = 3 → [\"((()))\",\"(()())\",\"(())()\",\"()(())\",\"()()()\"]. n = 1 → [\"()\"]. n ≤ 8.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'List every string of 2n slots filled with ( and ), then filter with Valid Parentheses', 'next' => 'brute'],
                ['label' => 'DFS: add ( or ); prune when l or r exceeds n, or when r exceeds l', 'next' => 'dfs'],
            ],
        ],
        'brute' => [
            'message' => "2^{2n} strings is wasteful, and most fail validity. You can refuse a closer the moment you have more ) than (.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only emit the repeated pattern ()()()... — one string per n', 'next' => 'wrong_repeat'],
                ['label' => 'dfs(l, r, t): prune l>n or r>n or l<r; record when l=r=n; else try t+( then t+)', 'next' => 'dfs'],
            ],
        ],
        'wrong_repeat' => [
            'message' => "You are wrong here.\n\"((()))\" and \"(()())\" are also well-formed. You must branch, not emit one pattern.\nStep back to when you chose the search space.",
            'outcome' => 'wrong',
            'rewind_to' => 'brute',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "l and r count how many openers and closers you have already placed. Why prune l < r (more closers than openers so far)?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'That prefix can never become valid — a closer has no matching opener yet', 'next' => 'example'],
                ['label' => 'You prune l < r so the stack stays nonempty, but )()( can still be fixed later', 'next' => 'wrong_later'],
            ],
        ],
        'wrong_later' => [
            'message' => "You are wrong. A prefix with more ) than ( is already illegal. Later characters cannot unpaid that closer.\nStep back to when you chose the prune.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'example' => [
            'message' => "Start dfs(0,0,\"\"). First branch adds ( until pruning or a closer is legal. n=3 yields five strings (Catalan number C3).\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Exponential in n (about O(4^n / sqrt(n)) answers); recursion depth O(n)', 'next' => 'success'],
                ['label' => 'O(n) because you only walk left then right once', 'next' => 'wrong_linear'],
            ],
        ],
        'wrong_linear' => [
            'message' => "You are wrong. You explore a binary tree of placements. The number of well-formed strings is Catalan, not linear.\nStep back to when you scored the search.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. DFS with counts l, r. Prune if l>n or r>n or l<r. Record when both hit n. Try an opener, then a closer. Time exponential in n; stack O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
