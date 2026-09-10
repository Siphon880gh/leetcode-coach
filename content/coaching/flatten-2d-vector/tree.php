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
            'message' => "Problem: Vector2D next/hasNext over vec in row-major order. next is only called when hasNext is true. [[1,2],[3],[4]] yields 1, 2, 3, 4. Empty inner lists are allowed.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy every integer into one array in the constructor; or Flatten Binary Tree to Linked List (114)', 'next' => 'copy'],
                ['label' => 'Keep row i and column j; forward() skips exhausted or empty rows, then next reads vec[i][j]', 'next' => 'idx'],
            ],
        ],
        'copy' => [
            'message' => "A copy works but uses O(N) extra up front. 114 mutates a tree. Nested List Iterator walks nested integers, not a 2D int list. Encode and Decode Strings is a length-prefix codec.\nWhat is the O(1) extra walk?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'while i in range and j ≥ len(vec[i]): i += 1, j = 0. hasNext after forward is i still in range', 'next' => 'idx'],
                ['label' => 'Assume every inner list has length at least 1; index vec[0][0] immediately', 'next' => 'wrong_empty'],
            ],
        ],
        'wrong_empty' => [
            'message' => "You are wrong here.\n[[],[1]] has an empty first row. You must skip it or next crashes / misses 1.\nStep back to when you assumed non-empty rows.",
            'outcome' => 'wrong',
            'rewind_to' => 'copy',
            'choices' => [],
        ],
        'idx' => [
            'message' => "next: forward, take vec[i][j], then j plus one. Each cell and each empty row is visited once, so calls are amortized O(1).\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[[1,2],[3],[4]] → 1, 2, 3, hasNext true, true, 4, then false', 'next' => 'cpx'],
                ['label' => 'Flatten Nested List Iterator: treat each int as a NestedInteger with lists inside', 'next' => 'wrong_341'],
            ],
        ],
        'wrong_341' => [
            'message' => "You are wrong. 341 is nested lists of NestedInteger. Here every inner value is a plain int.\nStep back to when you reused 341’s stack of iterators.",
            'outcome' => 'wrong',
            'rewind_to' => 'idx',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Amortized O(1) per call, O(1) extra besides vec. Not a constructor flatten, not 114, not 341, not a length-prefix encode.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Two indices plus forward() to skip empty rows; not a copied 1D array', 'next' => 'success'],
                ['label' => 'Count Univalue Subtrees postorder on vec as if it were a binary tree', 'next' => 'wrong_uni'],
            ],
        ],
        'wrong_uni' => [
            'message' => "You are wrong. Univalue counts matching tree nodes. This class iterates a 2D array.\nStep back to when you treated vec as a tree.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. i and j start at 0. forward skips spent or empty rows. hasNext is i in range after forward. next takes vec[i][j] then j += 1. Do not copy the grid, skip empty-row handling, or flatten a tree.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
