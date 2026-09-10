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
            'message' => "Problem: n posts, k colors. Two neighbors may match; three in a row may not. n = 3, k = 2 → 6. n = 1, k = 1 → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Paint House: min cost, neighbors must differ', 'next' => 'house'],
                ['label' => 'Two counts: last pair differ (f) vs last pair match (g)', 'next' => 'fg'],
            ],
        ],
        'house' => [
            'message' => "256 forbids any two neighbors the same and minimizes cost. Here you count paintings, and a pair of same colors is allowed once.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Ban every consecutive same color (k×(k−1)^{n−1} only)', 'next' => 'wrong_ban'],
                ['label' => 'f = ways last two differ; g = ways they match; no three in a row', 'next' => 'fg'],
            ],
        ],
        'wrong_ban' => [
            'message' => "You are wrong here.\nThat undercounts. n = 3, k = 2 would miss paintings like red-red-green.\nStep back to when you banned every pair of same colors.",
            'outcome' => 'wrong',
            'rewind_to' => 'house',
            'choices' => [],
        ],
        'fg' => [
            'message' => "Start f = k, g = 0. Then f' = (f + g) × (k − 1) (any other color from any valid prefix). g' = f (same color only if the previous pair already differed).\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'n = 3, k = 2 → 6. All-red and all-green are illegal. n = 7, k = 2 → 42', 'next' => 'cpx'],
                ['label' => 'g\' = f + g so you can stack a third same color', 'next' => 'wrong_three'],
            ],
        ],
        'wrong_three' => [
            'message' => "You are wrong. Copying f+g into g allows three in a row. Same-as-previous is only legal from a differing pair (old f).\nStep back to when you set g' from every prefix.",
            'outcome' => 'wrong',
            'rewind_to' => 'fg',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(1) extra if you roll two integers. Return f + g.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'f and g; next different times (k−1); next same copies f. Not Paint House, not a three-run', 'next' => 'success'],
                ['label' => 'Reuse House Robber skip/take on posts', 'next' => 'wrong_rob'],
            ],
        ],
        'wrong_rob' => [
            'message' => "You are wrong. Robber is take/skip adjacent houses. Here every post is painted; the state is the last pair of colors.\nStep back to when you mapped this to robber.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. f = last two differ, g = last two match. Next different: (f+g)×(k−1). Next same: old f only. Not Paint House’s min cost, not a ban on every pair.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
