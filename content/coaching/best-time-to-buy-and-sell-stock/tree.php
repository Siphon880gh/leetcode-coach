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
            'message' => "Problem: one buy, then one later sell. [7,1,5,3,6,4] → 5 (buy 1, sell 6). [7,6,4,3,1] → 0. n up to 1e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stock II: add every uphill (1 to 5 and 3 to 6) for 7, or buy day 0 and sell the last day', 'next' => 'ii'],
                ['label' => 'One pass: keep the lowest price so far, then max of (today minus that min)', 'next' => 'scan'],
            ],
        ],
        'ii' => [
            'message' => "Stock II allows as many trades as you want. Here you may complete only one transaction. Buying on day 0 at 7 and selling at 4 loses money.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Triangle’s min path, Unique Paths’ route count, or nested i < j for every pair', 'next' => 'wrong_other'],
                ['label' => 'ans starts at 0, mi at inf; for each v: ans = max(ans, v - mi), then mi = min(mi, v)', 'next' => 'scan'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nTriangle and Unique Paths are grid DP. Nested pairs are O(n²) and n is 1e5. This is one linear scan.\nStep back to when you copied a grid or a double loop.",
            'outcome' => 'wrong',
            'rewind_to' => 'ii',
            'choices' => [],
        ],
        'scan' => [
            'message' => "Time O(n), extra space O(1). You must update the answer with v - mi before you fold v into mi.\nWhy that order?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'If you min first, today vs today is 0, and you never sell against a cheaper past day', 'next' => 'ret'],
                ['label' => 'Order does not matter; same-day buy and sell is allowed for a free 0', 'next' => 'wrong_order'],
            ],
        ],
        'wrong_order' => [
            'message' => "You are wrong. Same-day trade is not a useful sale. If mi becomes v first, v - mi is always 0 that day, so the running max never sees a real profit.\nStep back to when you updated mi first.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return the integer profit. No profit → 0, not a negative.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '5 on the first sample, 0 on a strictly falling array — not the buy/sell days', 'next' => 'success'],
                ['label' => 'The pair of days [2, 5] or the prices [1, 6]', 'next' => 'wrong_days'],
            ],
        ],
        'wrong_days' => [
            'message' => "You are wrong. The judge wants the max profit number, not indices or the two prices.\nStep back to when you returned days or a pair.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One transaction. Track prefix min, then max(v - min). Update ans before mi. O(n) / O(1). Not Stock II’s many trades, not Triangle, not Unique Paths, not O(n²) pairs.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
