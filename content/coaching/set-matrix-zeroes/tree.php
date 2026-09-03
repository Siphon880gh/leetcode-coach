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
            'message' => "Problem: if a cell is 0, set its whole row and column to 0, in place. [[1,1,1],[1,0,1],[1,1,1]] → [[1,0,1],[0,0,0],[1,0,1]]. m,n ≤ 200.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'When you see a 0, immediately zero that row and column in the same scan', 'next' => 'now'],
                ['label' => 'First mark which rows and cols contain a 0, then zero in a second pass', 'next' => 'mark'],
            ],
        ],
        'now' => [
            'message' => "A 0 you just wrote looks like an original 0. Later cells then zero extra rows and columns that should stay nonzero.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy the matrix, zero the copy, then copy back', 'next' => 'wrong_copy'],
                ['label' => 'Record original zero rows and cols with two boolean arrays, then write zeros', 'next' => 'mark'],
            ],
        ],
        'wrong_copy' => [
            'message' => "You are wrong here.\nThe follow-up calls O(m·n) extra a bad idea. The writeup uses O(m+n) marks, still in place on the matrix.\nStep back to when you allocated a second matrix.",
            'outcome' => 'wrong',
            'rewind_to' => 'now',
            'choices' => [],
        ],
        'mark' => [
            'message' => "Second pass: if row[i] or col[j], set matrix[i][j]=0. Why not Rotate Image here?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'This zeros rows and cols; Rotate Image is a 90-degree permutation of cells', 'next' => 'void'],
                ['label' => 'Reverse then transpose; the zeros will rotate into place', 'next' => 'wrong_rot'],
            ],
        ],
        'wrong_rot' => [
            'message' => "You are wrong. Rotate Image does not zero rows. The signatures are different problems.\nStep back to when you reused Rotate Image.",
            'outcome' => 'wrong',
            'rewind_to' => 'mark',
            'choices' => [],
        ],
        'void' => [
            'message' => "The method returns void. Writeup time O(m·n), extra O(m+n).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Nothing — mutate matrix. Not Unique Paths II (obstacles are 1s, and that problem counts paths)', 'next' => 'success'],
                ['label' => 'The count of remaining nonzero cells', 'next' => 'wrong_count'],
            ],
        ],
        'wrong_count' => [
            'message' => "You are wrong. The signature is in-place void. Unique Paths II counts routes around walls.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'void',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Scan once: if matrix[i][j]==0, mark row[i] and col[j]. Scan again: if either mark, write 0. Time O(m·n), extra O(m+n). In-place zeros — not zeroing during the first scan, and not Rotate Image.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
