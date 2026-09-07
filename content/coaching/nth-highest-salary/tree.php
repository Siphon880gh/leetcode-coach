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
            'message' => "Problem: getNthHighestSalary(N) — the Nth highest distinct salary, or NULL if fewer than N uniques. n = 2 on 100, 200, 300 → 200. n = 2 on a single 100 → null. Same table, n = 1 → 300.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hard-code skip 1 like 176, or OFFSET N on raw rows without DISTINCT', 'next' => 'raw'],
                ['label' => 'SET N = N minus 1, then DISTINCT salary DESC LIMIT 1 OFFSET N, wrapped so a miss is NULL', 'next' => 'fn'],
            ],
        ],
        'raw' => [
            'message' => "176 is the N = 2 special case. OFFSET N on raw rows: duplicate maxes steal ranks, and older MySQL wants a constant OFFSET, not N minus 1 as an expression.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'RANK() = N after ties, or OFFSET N without decrementing', 'next' => 'wrong_off'],
                ['label' => 'Decrement N, DISTINCT DESC, LIMIT 1 OFFSET N; DENSE_RANK = N is the window twin', 'next' => 'fn'],
            ],
        ],
        'wrong_off' => [
            'message' => "You are wrong here.\nOFFSET 0 is the highest. After decrement, N = 2 skips one. RANK jumps past ties; DENSE_RANK does not.\nStep back to when you skipped N rows on the raw table.",
            'outcome' => 'wrong',
            'rewind_to' => 'raw',
            'choices' => [],
        ],
        'fn' => [
            'message' => "Wrap the inner SELECT so no row at that offset is NULL. Guard N less than 1 in Pandas.\nWhat is n = 2 on 100, 200, 300?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '200', 'next' => 'ans'],
                ['label' => '300 as OFFSET 2, or 100', 'next' => 'wrong_200'],
            ],
        ],
        'wrong_200' => [
            'message' => "You are wrong. After N minus 1, OFFSET 1 on distinct descending is 200, the second highest.\nStep back to when you scored n = 2.",
            'outcome' => 'wrong',
            'rewind_to' => 'fn',
            'choices' => [],
        ],
        'ans' => [
            'message' => "n = 1: OFFSET 0 after decrement is the max, 300. n = 2 on one unique 100: no second row → NULL. Not Delete Duplicate Emails, not a left join.\nWhat is n = 2 on a single 100?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'NULL', 'next' => 'success'],
                ['label' => '100 or 200 from the other sample', 'next' => 'wrong_null'],
            ],
        ],
        'wrong_null' => [
            'message' => "You are wrong. Fewer than two distinct salaries. Return NULL, not 100.\nStep back to when you scored n = 2 on one row.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Parameterize 176: decrement N, DISTINCT DESC, LIMIT 1 OFFSET N, wrap for NULL. DENSE_RANK = N, not RANK. n = 2 on 100, 200, 300 → 200. n = 2 on one 100 → NULL. n = 1 → 300.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
