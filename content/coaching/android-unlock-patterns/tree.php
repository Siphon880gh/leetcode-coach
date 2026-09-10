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
            'message' => "Problem: 3 by 3 lock, dots 1..9. Count unique valid patterns of length in [m, n]. Distinct dots. A hop through another dot’s center is legal only if that midpoint was already used. m=n=1 → 9. m=1, n=2 → 65.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Allow 1 to 3 without visiting 2, or reuse a dot later in the same pattern', 'next' => 'wrong_mid'],
                ['label' => 'Midpoint table, then DFS on unused cells; fold corners and edges by symmetry', 'next' => 'dfs'],
            ],
        ],
        'wrong_mid' => [
            'message' => "You are wrong here. 1–3 goes through 2’s center. Dots in a pattern are distinct. 2–9 does not go through 5’s center, so that hop is free.\nStep back to when you skipped the midpoint rule or reused a dot.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "cross[1][3]=2, cross[1][9]=5, cross[2][8]=5, and the other knight-style jumps. From i go to unused j if cross[i][j] is 0 or already visited. Count 1 when length is in [m, n]; stop past n. Unmark on the way back.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat 2 to 9 as blocked unless 5 was used, or count only length exactly n', 'next' => 'wrong_29'],
                ['label' => 'Four times a corner start, four times an edge start, plus center. Tiny 9-dot search', 'next' => 'cpx'],
            ],
        ],
        'wrong_29' => [
            'message' => "You are wrong. 2–9 does not pass through 5’s center. Lengths from m through n all count (m=1, n=2 is 65, not only the length-2 patterns).\nStep back to when you blocked 2–9 or counted only n.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Corners {1,3,7,9} are equivalent; edges {2,4,6,8} are equivalent. Do not multiply by four if you already started DFS from every cell. Space is the depth-9 stack.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Midpoint DFS, symmetry fold. Distinct dots. Count every length in [m, n]', 'next' => 'success'],
                ['label' => 'N-Queens style: one queen per row on the 3 by 3, ignore hop midpoints', 'next' => 'wrong_nq'],
            ],
        ],
        'wrong_nq' => [
            'message' => "You are wrong. This is a path on nine dots, not placing queens. The midpoint rule is the whole constraint.\nStep back to when you reused N-Queens.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Midpoint table, DFS unused cells, count lengths in [m, n]. Four times corner, four times edge, plus center. 1–3 needs 2; 2–9 does not need 5.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
