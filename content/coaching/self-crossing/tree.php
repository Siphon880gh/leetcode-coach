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
            'message' => "Problem: start at (0,0). Move distance[0] north, then west, south, east, repeating CCW. True iff the path crosses itself. [2,1,1,2] → true. [1,2,3,4] → false. [1,1,1,2,1] → true. n up to 1e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stamp every lattice point in a set, or ray-cast the polygon', 'next' => 'wrong_hash'],
                ['label' => 'Three local patterns: 4th hits 1st, 5th meets 1st, 6th crosses 1st', 'next' => 'local'],
            ],
        ],
        'wrong_hash' => [
            'message' => "You are wrong here. A single step can be 1e5 long and n is 1e5, so a cell set is too slow and too big. This is not winding-number geometry.\nStep back to when you simulated the lattice or ray-cast.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'local' => [
            'message' => "For i from 3: (1) d[i] ≥ d[i−2] and d[i−1] ≤ d[i−3]. (2) i≥4, d[i−1]==d[i−3], and d[i]+d[i−4] ≥ d[i−2]. (3) i≥5, the inner-rectangle inequalities. Growing spirals stay false.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only test adjacent segments (crossings skip a turn)', 'next' => 'wrong_adj'],
                ['label' => 'O(n) scan, O(1) extra; none of the three → false', 'next' => 'cpx'],
            ],
        ],
        'wrong_adj' => [
            'message' => "You are wrong. Consecutive edges share an endpoint but do not cross. The 4th can hit the 1st; the 6th can cross the 1st.\nStep back to when you only compared neighbors.",
            'outcome' => 'wrong',
            'rewind_to' => 'local',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "The judge wants a boolean, not the crossing point.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Three local CCW checks. Not a lattice set', 'next' => 'success'],
                ['label' => 'Return the crossing coordinate instead of true or false', 'next' => 'wrong_coord'],
            ],
        ],
        'wrong_coord' => [
            'message' => "You are wrong. The return value is whether a cross happened, not where.\nStep back to when you returned a point.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. 4th hits 1st, 5th meets 1st, or 6th crosses 1st. Do not stamp cells. Growing spirals stay false.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
