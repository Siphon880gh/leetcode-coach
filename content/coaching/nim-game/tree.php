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
            'message' => "Problem: n stones, you start, each turn take 1, 2, or 3. Last stone wins. Both optimal. True iff you can force a win. n=4 → false. n=1 and n=2 → true. n up to 2³¹ − 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DP or minimax over remaining stones for every n', 'next' => 'wrong_dp'],
                ['label' => 'Losing seats are multiples of 4; return n % 4 != 0', 'next' => 'mod'],
            ],
        ],
        'wrong_dp' => [
            'message' => "You are wrong here.\nDP is correct in theory but n can be 2³¹ − 1. The period is 4 because moves are 1..3.\nStep back to when you simulated every remainder.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'mod' => [
            'message' => "If n < 4, take all and win. If n = 4, every move leaves 1..3 and the opponent takes the rest. If n is 5, 6, or 7, leave 4. Opponent always restores a multiple of 4 when you leave a non-multiple.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Misère: last stone loses, so n=1 is false', 'next' => 'wrong_misere'],
                ['label' => 'O(1) time and space. Last stone wins', 'next' => 'cpx'],
            ],
        ],
        'wrong_misere' => [
            'message' => "You are wrong. This rule is last stone wins. n=1 is true.\nStep back to when you flipped the terminal rule.",
            'outcome' => 'wrong',
            'rewind_to' => 'mod',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Stone Game (877) is two piles / even-odd. Here one heap, subtract 1..3.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Win iff n is not a multiple of 4. Not DP, not misère', 'next' => 'success'],
                ['label' => 'n=8 is a win because you can take 3 and leave 5', 'next' => 'wrong_8'],
            ],
        ],
        'wrong_8' => [
            'message' => "You are wrong. 8 is a multiple of 4. After you take 1..3, the opponent leaves you 4, then you lose.\nStep back to when you scored n=8.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. return n % 4 != 0. Multiples of 4 lose under optimal play. Last stone wins. O(1). Not a DP loop, not misère.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
