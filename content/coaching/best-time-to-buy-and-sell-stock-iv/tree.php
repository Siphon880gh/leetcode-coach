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
            'message' => "Problem: at most k buy-sell pairs; sell before you buy again. k = 2, [2,4,1] → 2. k = 2, [3,2,6,5,0,3] → 7 (2→6 then 0→3). k up to 100, n up to 1000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stock II: sum every up-day, ignore k', 'next' => 'ii'],
                ['label' => 'k copies of cash vs holding; buy from j−1 cash, sell from same j holding', 'next' => 'dp'],
            ],
        ],
        'ii' => [
            'message' => "Stock II has no cap. Stock III is this machine with k = 2. Here k is an argument. Count a transaction when you buy.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always take Stock II even when k is 1', 'next' => 'wrong_ii'],
                ['label' => 'If k is at least n//2, then Stock II; else the k-state table', 'next' => 'dp'],
            ],
        ],
        'wrong_ii' => [
            'message' => "You are wrong here.\nWhen k is small you cannot take every rise. Only when k is at least n//2 can you trade every up-day.\nStep back to when you ignored k.",
            'outcome' => 'wrong',
            'rewind_to' => 'ii',
            'choices' => [],
        ],
        'dp' => [
            'message' => "f[j][0] cash after j buys; f[j][1] holding after j buys. Seed f[j][1] = −prices[0]. Each later price, walk j from k down to 1: sell then buy so you do not reuse the same day’s updated j−1 twice. Return f[k][0].\nFewer than k trades?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Allowed — leftover j never beats a better smaller j', 'next' => 'cpx'],
                ['label' => 'Must complete exactly k trades or return 0', 'next' => 'wrong_exact'],
            ],
        ],
        'wrong_exact' => [
            'message' => "You are wrong. At most k. [2,4,1] with k = 2 is 2 from one trade, not 0.\nStep back to when you forced exactly k trades.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n k), space O(k). Second sample 7.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The integer profit: 2 then 7, not the list of trades', 'next' => 'success'],
                ['label' => 'The two deals as pairs [[2,6],[0,3]]', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. The judge wants the max profit number, not the deals.\nStep back to when you returned pairs.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. At most k trades. Cash/hold per j, walk j downward. Huge k → Stock II. Return f[k][0]. Time O(n k).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
