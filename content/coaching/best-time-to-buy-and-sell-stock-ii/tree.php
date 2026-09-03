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
            'message' => "Problem: as many trades as you want, but hold at most one share. [7,1,5,3,6,4] → 7 (1→5 and 3→6). [1,2,3,4,5] → 4. [7,6,4,3,1] → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stock I: one prefix-min pass, so the sample is 5 (buy 1, sell 6)', 'next' => 'one'],
                ['label' => 'Greedy: add every positive adjacent gap prices[i] - prices[i-1]', 'next' => 'greedy'],
            ],
        ],
        'one' => [
            'message' => "Stock I allows one buy and one sell. Here you may sell and buy again. The sample’s two disjoint rises sum to 7, not 5.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Triangle’s min path, Unique Paths’ route count, or Stock III’s at-most-two cap', 'next' => 'wrong_other'],
                ['label' => 'sum max(0, b - a) for each consecutive pair; skip down days', 'next' => 'greedy'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nTriangle and Unique Paths are grids. Stock III caps at two trades. This problem has no trade-count cap, only “one share at a time.”\nStep back to when you copied a grid or a two-trade cap.",
            'outcome' => 'wrong',
            'rewind_to' => 'one',
            'choices' => [],
        ],
        'greedy' => [
            'message' => "Time O(n), extra space O(1). A climb [1,2,3,4,5] is (2-1)+(3-2)+(4-3)+(5-4)=4, same as buy first sell last.\nWhy is summing adjacent rises legal?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Same-day sell then buy is allowed, so a long climb equals many 1-day flips', 'next' => 'ret'],
                ['label' => 'You must sell every day; holding through a rise is forbidden', 'next' => 'wrong_hold'],
            ],
        ],
        'wrong_hold' => [
            'message' => "You are wrong. Holding the whole climb is valid and earns the same total. Adjacent sums are just an accounting trick, not a forced daily sell.\nStep back to when you required a sell every day.",
            'outcome' => 'wrong',
            'rewind_to' => 'greedy',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return the integer profit. Falling array → 0, not a negative.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '7 on the first sample, 4 on a strict climb, 0 when prices only fall — not Stock I’s 5', 'next' => 'success'],
                ['label' => 'The list of trades [[1,5],[3,6]]', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. The judge wants the max profit number, not the trade list.\nStep back to when you returned pairs.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Unlimited trades, one share. Sum every positive adjacent gap. O(n) / O(1). Not Stock I’s single pair (5), not Stock III’s two-trade cap, not Triangle, not Unique Paths.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
