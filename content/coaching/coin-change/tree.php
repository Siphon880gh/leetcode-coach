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
            'message' => "Problem: fewest coins to make amount; infinite supply of each denomination. Impossible → −1. [1,2,5] and 11 → 3 (5+5+1). [2] and 3 → −1. amount 0 → 0. Up to 12 coins; amount up to 1e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Greedy largest-first, or 518 (count combinations), or 0-1 each coin once', 'next' => 'wrong_greedy'],
                ['label' => 'Unbounded knapsack: f[j] = min(f[j], f[j − x] + 1), j walks forward', 'next' => 'dp'],
            ],
        ],
        'wrong_greedy' => [
            'message' => "You are wrong here.\n[1,3,4] amount 6 is two 3s, not 4+1+1. 518 counts ways. Using each coin once is 0-1 knapsack, not this problem.\nStep back to when you used greedy, 518, or 0-1.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dp' => [
            'message' => "f[0] = 0; other slots start as infinity. For each coin x, for j from x to amount: f[j] = min(f[j], f[j − x] + 1). Forward j reuses x in the same pass. If f[amount] is still infinity, return −1. 279 Perfect Squares is this DP with coins 1, 4, 9, …\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Walk j downward (0-1), or treat amount 0 as impossible', 'next' => 'wrong_dir'],
                ['label' => 'O(m × amount). Return the count, not the coin list', 'next' => 'cpx'],
            ],
        ],
        'wrong_dir' => [
            'message' => "You are wrong. A downward inner loop is 0-1 (each coin once). amount 0 needs 0 coins.\nStep back to when you reversed j or rejected a zero amount.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "BFS by coin count from 0 is also valid (first time you hit amount). Same fewest-coins answer.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Forward unbounded DP, −1 if unreachable. Not greedy, not 518', 'next' => 'success'],
                ['label' => 'Return the product of coin values that sum to amount', 'next' => 'wrong_prod'],
            ],
        ],
        'wrong_prod' => [
            'message' => "You are wrong. The answer is a count of coins, not a product of face values.\nStep back to when you multiplied denominations.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Unbounded knapsack, inner loop forward. Fewest coins, or −1. amount 0 is 0. Not greedy, not 518.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
