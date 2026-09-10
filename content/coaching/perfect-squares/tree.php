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
            'message' => "Problem: fewest perfect squares that sum to n. 12 → 3 (4+4+4). 13 → 2 (4+9).\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Greedy: peel the largest square (12 as 9+1+1+1)', 'next' => 'greedy'],
                ['label' => 'Unbounded knapsack: squares are coins you may reuse', 'next' => 'dp'],
            ],
        ],
        'greedy' => [
            'message' => "9+1+1+1 uses four. Three 4s is better. Coin Change has the same greedy trap.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '0-1 knapsack: each square value used at most once', 'next' => 'wrong_01'],
                ['label' => 'f[j] = min over i² ≤ j of f[j − i²] + 1; reuse by scanning j forward', 'next' => 'dp'],
            ],
        ],
        'wrong_01' => [
            'message' => "You are wrong here.\n12 needs three copies of 4. A 0-1 item per square type cannot do that unless you duplicate items.\nStep back to when you forbade reuse.",
            'outcome' => 'wrong',
            'rewind_to' => 'greedy',
            'choices' => [],
        ],
        'dp' => [
            'message' => "f[0] = 0, rest infinity. For each i, sq = i × i; for j from sq to n: f[j] = min(f[j], f[j − sq] + 1). Return f[n]. Lagrange: at most four squares.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '12 → 3. 13 → 2. A number 4^k(8m+7) needs four', 'next' => 'cpx'],
                ['label' => 'Add Digits: digital root of n is the answer', 'next' => 'wrong_digits'],
            ],
        ],
        'wrong_digits' => [
            'message' => "You are wrong. Add Digits (258) is a different problem. 12’s digital root is 3 by coincidence, 13 is 4 but the square count is 2.\nStep back to when you used the digital root.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n sqrt(n)) time, O(n) space for the 1-D array.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Square coins, unbounded DP. Not greedy largest, not 0-1, not Add Digits', 'next' => 'success'],
                ['label' => 'Always return 4 because of the four-square theorem', 'next' => 'wrong_four'],
            ],
        ],
        'wrong_four' => [
            'message' => "You are wrong. Four is an upper bound, not the least count. 13 is two squares.\nStep back to when you always returned 4.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Unbounded knapsack with square coins. f[j] = min(f[j], f[j − i²] + 1). 12 is three 4s, not greedy 9s. Not Add Digits, not 0-1 knapsack.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
