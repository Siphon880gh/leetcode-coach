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
            'message' => "Problem: n×n matrix, rotate 90 degrees clockwise in place. Do not allocate another n×n matrix. [[1,2,3],[4,5,6],[7,8,9]] → [[7,4,1],[8,5,2],[9,6,3]]. n ≤ 20.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'New matrix: dest[j][n-1-i] = matrix[i][j], then copy dest back', 'next' => 'extra'],
                ['label' => 'Reverse the rows top-to-bottom, then transpose by swapping matrix[i][j] with matrix[j][i]', 'next' => 'inplace'],
            ],
        ],
        'extra' => [
            'message' => "That mapping is correct, but a second n×n array is extra O(n²) space the problem forbids.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'n is at most 20, so the extra matrix is allowed in practice', 'next' => 'wrong_n'],
                ['label' => 'Two in-place flips compose the same map: reverse upside-down, then swap across the main diagonal', 'next' => 'inplace'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong here.\nThe constraint is the algorithm, not the judge memory. You must mutate matrix itself.\nStep back to when you allocated dest.",
            'outcome' => 'wrong',
            'rewind_to' => 'extra',
            'choices' => [],
        ],
        'inplace' => [
            'message' => "Why is a transpose alone not a 90-degree clockwise rotation?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Transpose is a reflection: (i,j) becomes (j,i). Clockwise 90 needs (i,j) → (j, n-1-i)', 'next' => 'example'],
                ['label' => 'Transpose is already clockwise 90; the reverse step is only for counterclockwise', 'next' => 'wrong_t'],
            ],
        ],
        'wrong_t' => [
            'message' => "You are wrong. Transpose of [[1,2,3],[4,5,6],[7,8,9]] is [[1,4,7],[2,5,8],[3,6,9]], not the required [[7,4,1],…]. Reverse then transpose (or transpose then reverse each row) hits the clockwise map.\nStep back to when you described the map.",
            'outcome' => 'wrong',
            'rewind_to' => 'inplace',
            'choices' => [],
        ],
        'example' => [
            'message' => "After reversing rows, row 0 is [7,8,9]. After transpose, it becomes column 0 of the result? The first row of the answer is [7,4,1]. Either order works if you pair reverse-rows with transpose, or transpose with reverse-each-row. Time is a constant number of n×n passes.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n²) time, O(1) extra', 'next' => 'success'],
                ['label' => 'O(n) because you only reverse n rows', 'next' => 'wrong_lin'],
            ],
        ],
        'wrong_lin' => [
            'message' => "You are wrong. Each of n² cells is swapped a constant number of times. That is Θ(n²).\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Clockwise 90: reverse upside-down, then transpose (j < i). Same map as dest[j][n-1-i] without a second matrix. Time O(n²), extra O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
