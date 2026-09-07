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
            'message' => "Problem: one column SecondHighestSalary — the second-highest distinct salary, or NULL if none. 100, 200, 300 → 200. One row 100 → null. Two rows both 300 → null.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'LIMIT 1 OFFSET 1 on raw rows, or a LEFT JOIN like Combine Two Tables', 'next' => 'raw'],
                ['label' => 'MAX of salaries strictly below the overall MAX, or DISTINCT ordered DESC skip one', 'next' => 'distinct'],
            ],
        ],
        'raw' => [
            'message' => "OFFSET 1 without DISTINCT: two 300s make the second row another 300. Combine Two Tables is a join, not a rank. Empty OFFSET can return no row instead of NULL unless you wrap a scalar subquery.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'RANK() after two 300s is 2, so pick rk = 2', 'next' => 'wrong_rank'],
                ['label' => 'Work on distinct values: MAX below MAX, or DENSE_RANK = 2', 'next' => 'distinct'],
            ],
        ],
        'wrong_rank' => [
            'message' => "You are wrong here.\nPlain RANK jumps to 3 after two tied maxes. DENSE_RANK keeps the next distinct at 2.\nStep back to when you used RANK.",
            'outcome' => 'wrong',
            'rewind_to' => 'raw',
            'choices' => [],
        ],
        'distinct' => [
            'message' => "Wrap SELECT DISTINCT salary ORDER BY salary DESC LIMIT 1, 1 in an outer SELECT so a missing second row is NULL. Ties at the top drop together: 300, 300, 100 → 100.\nWhat is 100, 200, 300?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '200', 'next' => 'ans'],
                ['label' => '100, or 300 as the first skip', 'next' => 'wrong_200'],
            ],
        ],
        'wrong_200' => [
            'message' => "You are wrong. Distinct descending is 300 then 200. The second is 200, not 100 and not another 300.\nStep back to when you scored 100, 200, 300.",
            'outcome' => 'wrong',
            'rewind_to' => 'distinct',
            'choices' => [],
        ],
        'ans' => [
            'message' => "One unique salary has no second distinct. Time O(n). Not Tenth Line, not a left join.\nWhat is a single row of 100?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'NULL', 'next' => 'success'],
                ['label' => '100 or 200 from the other sample', 'next' => 'wrong_null'],
            ],
        ],
        'wrong_null' => [
            'message' => "You are wrong. There is no second distinct salary. Return NULL, not 100.\nStep back to when you scored one row.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Distinct, then skip the max (or MAX below MAX). Wrap so no second row is NULL. Not OFFSET on raw ties. 100, 200, 300 → 200. One 100 → NULL. Two 300s → NULL.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
