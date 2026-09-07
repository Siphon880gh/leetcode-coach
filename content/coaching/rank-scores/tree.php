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
            'message' => "Problem: every score plus its rank, high to low. Ties share a rank. After a tie the next rank is the next integer (no holes). Sample: two 4.00s are 1; 3.85 is 2; two 3.65s are 3; 3.50 is 4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'RANK() OVER (ORDER BY score DESC), or ROW_NUMBER so each row is unique', 'next' => 'holes'],
                ['label' => 'DENSE_RANK() OVER (ORDER BY score DESC), quote the rank alias', 'next' => 'dense'],
            ],
        ],
        'holes' => [
            'message' => "RANK leaves a hole: two 4.00s as 1, then 3.85 as 3. ROW_NUMBER splits the two 4.00s into 1 and 2. Nth Highest Salary picked one dense rank; here you emit that rank for every row.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep RANK and accept the hole, or sort by id instead of score', 'next' => 'wrong_rank'],
                ['label' => 'DENSE_RANK: same score same rank, next distinct is plus one', 'next' => 'dense'],
            ],
        ],
        'wrong_rank' => [
            'message' => "You are wrong here.\nThe problem forbids holes. After two firsts, 3.85 must be 2.\nStep back to when you used RANK or ROW_NUMBER.",
            'outcome' => 'wrong',
            'rewind_to' => 'holes',
            'choices' => [],
        ],
        'dense' => [
            'message' => "Quote the column: rank is reserved. Order the result by score descending. Pandas: score.rank(method=\"dense\", ascending=False), drop id.\nWhat rank is 3.85 after two 4.00s?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '2', 'next' => 'ans'],
                ['label' => '3 from RANK, or 1 like the 4.00s', 'next' => 'wrong_385'],
            ],
        ],
        'wrong_385' => [
            'message' => "You are wrong. Two 4.00s share 1. The next distinct score is 2, not a hole of 3 and not another 1.\nStep back to when you scored 3.85.",
            'outcome' => 'wrong',
            'rewind_to' => 'dense',
            'choices' => [],
        ],
        'ans' => [
            'message' => "Two 3.65s then share 3; 3.50 is 4. Not Second Highest Salary (one scalar). Not a self-join on yesterday.\nWhat ranks are the two 3.65s?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Both 3', 'next' => 'success'],
                ['label' => '3 and 4, or both 4 after a RANK hole', 'next' => 'wrong_365'],
            ],
        ],
        'wrong_365' => [
            'message' => "You are wrong. Ties share. After rank 2 for 3.85, both 3.65s are 3.\nStep back to when you scored the 3.65s.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. DENSE_RANK on score descending, quote rank, order score high to low. RANK holes. ROW_NUMBER splits ties. Sample: 4.00 → 1, 4.00 → 1, 3.85 → 2, 3.65 → 3, 3.65 → 3, 3.50 → 4.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
