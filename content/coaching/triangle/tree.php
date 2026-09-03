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
            'message' => "Problem: min path sum top to bottom. From index j you may go to j or j+1 on the next row. [[2],[3,4],[6,5,7],[4,1,8,3]] → 11 (2+3+5+1). [[-10]] → -10. Up to 200 rows.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Minimum Path Sum’s grid (only down and right), or Pascal I’s binomial rows', 'next' => 'grid'],
                ['label' => 'Bottom-up DP: from the last row, each cell is itself plus min of the two below', 'next' => 'dp'],
            ],
        ],
        'grid' => [
            'message' => "Min Path Sum is a rectangle with right/down. Pascal fills 1s and adjacent sums, not a min. Here each row is one longer, and you pick j or j+1 going down.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Unique Paths counting routes, or Pascal II returning one binomial row', 'next' => 'wrong_count'],
                ['label' => 'f[i][j] = triangle[i][j] + min(f[i+1][j], f[i+1][j+1]); answer f[0][0]', 'next' => 'dp'],
            ],
        ],
        'wrong_count' => [
            'message' => "You are wrong here.\nUnique Paths counts ways. Pascal II is [1,3,3,1]. This is a min sum (can be negative).\nStep back to when you counted or copied Pascal.",
            'outcome' => 'wrong',
            'rewind_to' => 'grid',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Initialize f below the last row to 0. Loop i from n-1 down to 0. Time O(n²).\nWhy start at the bottom instead of the top?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The recurrence needs the two children already computed; the top is the last answer', 'next' => 'ret'],
                ['label' => 'Greedy: always take the smaller of the two below from the apex', 'next' => 'wrong_greedy'],
            ],
        ],
        'wrong_greedy' => [
            'message' => "You are wrong. A cheap next step can lead to a costly bottom. The sample needs 3 not 4 at row 1, but that is not “always min locally” in general.\nStep back to when you greeded.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return the integer f[0][0], not the triangle of paths.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The min sum 11, not Unique Paths’ route count and not Pascal’s nested rows', 'next' => 'success'],
                ['label' => 'The path as a list [2,3,5,1]', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. The judge wants the sum, not the chosen cells.\nStep back to when you returned a path list.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Bottom-up: cell + min of the two below. Return f[0][0]. O(n²). Not rectangular Min Path Sum, not Unique Paths, not Pascal I/II, not greedy local min.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
