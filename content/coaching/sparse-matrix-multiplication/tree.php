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
            'message' => "Problem: mat1 is m by k, mat2 is k by n. Return mat1 times mat2 (always legal). Sample [[1,0,0],[-1,0,3]] times [[7,0,0],[0,0,0],[0,0,1]] → [[7,0,0],[-7,0,3]]. [[0]] times [[0]] → [[0]]. Dimensions up to 100.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Add corresponding cells (matrix addition), or transpose mat2 first for no reason', 'next' => 'wrong_add'],
                ['label' => 'Dot row i of mat1 with column j of mat2; skip zeros by compressing rows', 'next' => 'comp'],
            ],
        ],
        'wrong_add' => [
            'message' => "You are wrong here.\nThis is multiplication, not addition. You do not have to transpose unless you stored mat2 by columns.\nStep back to when you added cells or forced a transpose.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'comp' => [
            'message' => "Naive ans[i][j] += mat1[i][t] times mat2[t][j] is correct but walks zeros. Compress each row to (col, val) nonzeros. For each (t, x) in row i of mat1, for each (j, y) in row t of mat2, add x times y into ans[i][j]. Shared index t is the inner dimension k.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Pair row i of mat1 with row i of mat2 (drop the shared k)', 'next' => 'wrong_k'],
                ['label' => 'O(m n k) worst case; sparse input is cheaper', 'next' => 'cpx'],
            ],
        ],
        'wrong_k' => [
            'message' => "You are wrong. The inner loop is the shared k: column of mat1 matches row of mat2.\nStep back to when you aligned the wrong axes.",
            'outcome' => 'wrong',
            'rewind_to' => 'comp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Answer shape is m by n. Zeros in the sample stay zeros.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Compress nonzeros, scatter products. Not addition, not dropping k', 'next' => 'success'],
                ['label' => 'Output must be mat2 times mat1 (swap the factors)', 'next' => 'wrong_swap'],
            ],
        ],
        'wrong_swap' => [
            'message' => "You are wrong. Return mat1 times mat2. Order matters.\nStep back to when you swapped the factors.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Skip zeros: compress rows, then scatter x times y along the shared t. Sample → [[7,0,0],[-7,0,3]]. Not matrix addition.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
