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
            'message' => "Problem: n bulbs start off. Round i (1 through n) toggles every i-th bulb. How many are on after n rounds? n = 3 → 1. n = 0 → 0. n = 1 → 1. n up to 1e9.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Simulate n rounds on a boolean array, or count primes up to n', 'next' => 'wrong_sim'],
                ['label' => 'A bulb ends on iff it has an odd number of divisors (perfect squares)', 'next' => 'squares'],
            ],
        ],
        'wrong_sim' => [
            'message' => "You are wrong here.\nn is 1e9; n rounds on n bulbs will not finish. Prime count is a different problem (204).\nStep back to when you simulated or counted primes.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'squares' => [
            'message' => "Bulb k is toggled once per divisor of k. Divisors pair as d and k/d, so the count is even unless d equals k/d (k is a square). Odd toggles from off means on. Squares in 1..n: floor(sqrt(n)). 12 has six divisors (off). 16 has five (on).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return n (every bulb on after round 1) or ceil(sqrt(n))', 'next' => 'wrong_round1'],
                ['label' => 'O(1): int(sqrt(n)). n = 0 is 0', 'next' => 'cpx'],
            ],
        ],
        'wrong_round1' => [
            'message' => "You are wrong. Later rounds turn bulbs off. ceil would count a square larger than n.\nStep back to when you kept round-1 or used ceil.",
            'outcome' => 'wrong',
            'rewind_to' => 'squares',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "672 / 1529 / 1521 are other bulb problems (subset flips, or a different cost). This one is only floor(sqrt(n)).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'On iff perfect square. Answer floor(sqrt(n)). Not a simulation', 'next' => 'success'],
                ['label' => 'Count odd numbers up to n (odd bulbs stay on)', 'next' => 'wrong_odd'],
            ],
        ],
        'wrong_odd' => [
            'message' => "You are wrong. Odd indices are not the same as odd divisor counts. Sample n = 3 leaves only bulb 1 on, not two odds.\nStep back to when you counted odd indices.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Odd divisor count only for squares. Return floor(sqrt(n)). O(1). Not a 1e9 simulation.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
