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
            'message' => "Problem: return the first numRows of Pascal’s triangle. 5 → [[1],[1,1],[1,2,1],[1,3,3,1],[1,4,6,4,1]]. 1 → [[1]]. numRows 1..30.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Unique Paths counting grid walks, or Next Right II linking tree pointers', 'next' => 'paths'],
                ['label' => 'Start f=[[1]]; each new row is 1, then pairwise sums of the last row, then 1', 'next' => 'row'],
            ],
        ],
        'paths' => [
            'message' => "Unique Paths returns one integer. Next Right mutates .next. This returns nested integer rows. Interior values are the two numbers above added.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Unique BST I Catalan counts, or Distinct Subsequences of two strings', 'next' => 'wrong_count'],
                ['label' => 'Repeat numRows-1 times: g = [1] + [a+b for adjacent in f[-1]] + [1]; append g', 'next' => 'row'],
            ],
        ],
        'wrong_count' => [
            'message' => "You are wrong here.\nThose problems return a single count. Pascal’s triangle is the list of rows themselves.\nStep back to when you returned one integer.",
            'outcome' => 'wrong',
            'rewind_to' => 'paths',
            'choices' => [],
        ],
        'row' => [
            'message' => "Time O(n²). Ends of every row stay 1. The 2 in [1,2,1] is 1+1 from the row above.\nWhy pairwise on the previous row, not on the new row as you write it?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Each interior cell is the sum of the two values directly above, already finished', 'next' => 'ret'],
                ['label' => 'Overwrite the previous row in place so you only keep one list (that is Pascal II)', 'next' => 'wrong_ii'],
            ],
        ],
        'wrong_ii' => [
            'message' => "You are wrong. Pascal II asks for one row. This problem must keep every prior row in the answer.\nStep back to when you discarded earlier rows.",
            'outcome' => 'wrong',
            'rewind_to' => 'row',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return f. numRows=1 is [[1]], not [1].\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The nested rows, not a boolean and not a single flattened list', 'next' => 'success'],
                ['label' => 'Only the last row [1,4,6,4,1]', 'next' => 'wrong_last'],
            ],
        ],
        'wrong_last' => [
            'message' => "You are wrong. The sample for 5 has five inner lists, including [1] and [1,1].\nStep back to when you returned only the last row.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Seed [[1]]; each next row is 1 + adjacent sums + 1. O(n²). Not Unique Paths, not Unique BST I, not Distinct Subsequences, not Next Right, not Pascal II’s single row.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
