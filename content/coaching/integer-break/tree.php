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
            'message' => "Problem: break n into k ≥ 2 positive integers that sum to n; maximize the product. n from 2 to 58. n=2 → 1 (1+1). n=10 → 36 (3+3+4).\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return n itself, or count the number of partitions', 'next' => 'wrong_n'],
                ['label' => 'Prefer 3s; leftover 1 is poison so rewrite as 2+2', 'next' => 'threes'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong here. k must be at least 2, so n=2 and n=3 are n−1, not n. This is a max product, not a count of ways.\nStep back to when you returned n or counted partitions.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'threes' => [
            'message' => "3 is the best factor. Remainder 0: all 3s. Remainder 2: one extra 2. Remainder 1: do not keep 3+1 (product 3). Pull a 3 back and write 2+2 (times 4). 10 = 3+3+4. DP twin: f[i] = max over j of j times (i−j) and j times f[i−j].\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Leave remainder 1 as 3+1, or greedily use only 2s', 'next' => 'wrong_1'],
                ['label' => 'n=2 → 1; n=10 → 36. Math O(1) or DP O(n²)', 'next' => 'cpx'],
            ],
        ],
        'wrong_1' => [
            'message' => "You are wrong. 3+1 loses to 2+2. Using only 2s is worse than mixing 3s when n is large (10 would be 32, not 36).\nStep back to when you kept a leftover 1 or skipped 3s.",
            'outcome' => 'wrong',
            'rewind_to' => 'threes',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Must split. Math: if n < 4 return n−1; else 3s with the remainder-1 rewrite. Time O(1) or O(n²).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Prefer 3s, never leave a leftover 1. Must split', 'next' => 'success'],
                ['label' => 'Return 4 for n=4 as unsplit, or maximize the sum instead', 'next' => 'wrong_sum'],
            ],
        ],
        'wrong_sum' => [
            'message' => "You are wrong. n=4 must split (2+2 product 4, same as 4 but k ≥ 2 is already 2+2). The judge wants the product, not the sum.\nStep back to when you skipped the split or maximized the sum.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Prefer 3s; leftover 1 becomes 2+2. Must split. Not a partition count.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
