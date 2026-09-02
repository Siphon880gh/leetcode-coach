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
            'message' => "Problem: convert num in 1..3999 to Roman. 3749 → \"MMMDCCXLIX\", 58 → \"LVIII\", 1994 → \"MCMXCIV\".\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Write four I\'s for 4, nine I\'s for 9', 'next' => 'repeat'],
                ['label' => 'Greedy table from M, CM, D, CD, … down to I, peel the largest that fits', 'next' => 'greedy'],
            ],
        ],
        'repeat' => [
            'message' => "You cannot append I, X, C, or M four times. 4 and 9 use subtractive pairs (IV, IX, XL, XC, CD, CM).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '49 is IL — I less than L', 'next' => 'wrong_il'],
                ['label' => 'Put 900, 400, 90, 40, 9, 4 in the greedy table so they win before 500/50/5', 'next' => 'greedy'],
            ],
        ],
        'wrong_il' => [
            'message' => "You are wrong here.\nSubtractive forms are only IV, IX, XL, XC, CD, CM. 49 is XL+IX (decimal places), not IL.\nStep back to when you listed the pairs.",
            'outcome' => 'wrong',
            'rewind_to' => 'repeat',
            'choices' => [],
        ],
        'greedy' => [
            'message' => "cs/vs: M 1000, CM 900, D 500, CD 400, C 100, XC 90, L 50, XL 40, X 10, IX 9, V 5, IV 4, I 1.\nWhile num >= v, append c and subtract v. Why is CM before D?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '900 is larger than 500, so 1994 takes M then CM, not MDCCCC', 'next' => 'example'],
                ['label' => 'Repeat D or V to make 1000 or 10 — those letters may stack', 'next' => 'wrong_d'],
            ],
        ],
        'wrong_d' => [
            'message' => "You are wrong. V, L, and D are never repeated. 1000 is M, 10 is X (or IX/XL as needed).\nStep back to when you ordered the table.",
            'outcome' => 'wrong',
            'rewind_to' => 'greedy',
            'choices' => [],
        ],
        'example' => [
            'message' => "3749: MMM (3000) + DCC (700) + XL (40) + IX (9). 58: L + VIII.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The concatenated greedy symbols — O(1) table size for this range', 'next' => 'success'],
                ['label' => 'The symbols sorted alphabetically', 'next' => 'wrong_alpha'],
            ],
        ],
        'wrong_alpha' => [
            'message' => "You are wrong. Order is value order, largest first, not A–Z. MMMDCCXLIX is the required spelling.\nStep back to when you joined the result.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Greedy from a table that includes subtractive pairs. Peel the largest fit until num is 0. Time O(number of symbols written).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
