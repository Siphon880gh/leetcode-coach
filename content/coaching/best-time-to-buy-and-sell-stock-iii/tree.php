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
            'message' => "Problem: at most two transactions; sell before you buy again. [3,3,5,0,0,3,1,4] → 6. [1,2,3,4,5] → 4. [7,6,4,3,1] → 0. n up to 1e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stock I’s one pair (4) or Stock II’s sum of every rise (8 on the first sample)', 'next' => 'cap'],
                ['label' => 'Four states: first buy, first sell, second buy, second sell', 'next' => 'dp'],
            ],
        ],
        'cap' => [
            'message' => "Stock I is one trade. Stock II has no cap, so it can take three rises. Here k is 2, so the extra rise is illegal.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Triangle’s min path, Unique Paths’ counts, or a 2D grid of days vs leftover trades', 'next' => 'wrong_other'],
                ['label' => 'f1=-prices[0], f2=0, f3=-prices[0], f4=0; then max into each state in that order', 'next' => 'dp'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nTriangle and Unique Paths are other grids. You do not need a full n×k table: four rolling variables are enough.\nStep back to when you copied a grid.",
            'outcome' => 'wrong',
            'rewind_to' => 'cap',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Each day: f1 = max(f1, -price); f2 = max(f2, f1+price); f3 = max(f3, f2-price); f4 = max(f4, f3+price). Same-day buy/sell is profit 0 and is harmless. O(n) / O(1).\nWhy return f4, not f2?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'f4 is after the second sale; using only one trade is still allowed because f4 never drops below a one-trade profit', 'next' => 'ret'],
                ['label' => 'You must always complete two trades, so a one-peak array should return 0', 'next' => 'wrong_must'],
            ],
        ],
        'wrong_must' => [
            'message' => "You are wrong. At most two means zero or one is fine. [1,2,3,4,5] is 4 from a single hold, not 0.\nStep back to when you forced two trades.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return the integer f4.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '6, 4, and 0 on the three samples — not Stock II’s 8 and not the trade list', 'next' => 'success'],
                ['label' => 'The two trades as pairs [[0,3],[1,4]]', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. The judge wants the max profit number, not the two deals.\nStep back to when you returned pairs.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. At most two trades. Four states f1..f4, return f4. O(n) / O(1). Not Stock I’s one pair, not Stock II’s unlimited rises, not Triangle, not Unique Paths.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
