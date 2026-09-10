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
            'message' => "Problem: n houses, three colors, neighbors cannot share a color. costs[i][0/1/2] is the price. Return min total. [[17,2,17],[16,16,5],[14,3,19]] → 10 (blue, green, blue).\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'House Robber skip/take; or greedy cheapest color on every house', 'next' => 'rob'],
                ['label' => 'Three rolling mins: next red is min(old blue, old green) plus this red cost', 'next' => 'dp'],
            ],
        ],
        'rob' => [
            'message' => "House Robber forbids adjacent takes; here every house is painted. Greedy min of each row can paint two neighbors the same cheap color.\nHow do you update the triple together?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'a, b, c = min(b,c)+ca, min(a,c)+cb, min(a,b)+cc. Copy old values if you write in place', 'next' => 'dp'],
                ['label' => 'Paint Fence: count colorings with no three in a row, ignore costs', 'next' => 'wrong_fence'],
            ],
        ],
        'wrong_fence' => [
            'message' => "You are wrong here.\nPaint Fence (276) counts ways. This problem returns a min cost with neighbors different.\nStep back to when you counted paintings instead of costs.",
            'outcome' => 'wrong',
            'rewind_to' => 'rob',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Start a=b=c=0. After the last house, min of the three. One house is that house’s cheapest color.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[[17,2,17],[16,16,5],[14,3,19]] → 10', 'next' => 'cpx'],
                ['label' => 'Allow two adjacent houses the same color when that color is cheaper', 'next' => 'wrong_same'],
            ],
        ],
        'wrong_same' => [
            'message' => "You are wrong. Adjacent houses must differ even if repeating a color would be cheaper.\nStep back to when you dropped the neighbor constraint.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(1) space. Paint House II generalizes to k colors; with three, three integers are enough. Not skip/take, not greedy per row, not a way count.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Three rolling costs; next color takes the min of the other two plus this cost', 'next' => 'success'],
                ['label' => 'Enumerate all 3 to the n colorings', 'next' => 'wrong_enum'],
            ],
        ],
        'wrong_enum' => [
            'message' => "You are wrong. n is up to 100; 3 to the n is huge. The rolling triple is enough.\nStep back to when you brute-forced colorings.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Keep min totals ending red, blue, green. New red cannot use old red. Assign the triple together. Return the min of the three. Do not skip houses, greedy-per-row, or count Paint Fence ways.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
