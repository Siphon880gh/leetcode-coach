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
            'message' => "Problem: m by n grid of '1' (land) and '0' (water). Count 4-connected islands (not diagonal). First sample → 1. Second sample → 3. Up to 300 by 300.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count every 1, connect on diagonals, or flood from the border like Surrounded Regions', 'next' => 'count'],
                ['label' => 'Scan; each leftover 1 is a new island: flood 4-way and paint that land to 0', 'next' => 'flood'],
            ],
        ],
        'count' => [
            'message' => "Counting every 1 overcounts a blob. Diagonals do not connect. Surrounded Regions saves border O’s and flips the rest; here you return a count.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Right Side View: one tree value per depth', 'next' => 'wrong_tree'],
                ['label' => 'Increment once per component, then DFS or BFS to mark the whole island', 'next' => 'flood'],
            ],
        ],
        'wrong_tree' => [
            'message' => "You are wrong here.\nRight Side View walks a binary tree. This is a grid of characters.\nStep back to when you reused Right Side View.",
            'outcome' => 'wrong',
            'rewind_to' => 'count',
            'choices' => [],
        ],
        'flood' => [
            'message' => "Cells are characters: compare to '1', not integer 1. Union-find on adjacent lands counts the same components. Time O(m · n).\nWhich sample counts?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'First sample is 1 blob; second sample is 3 islands', 'next' => 'cpx'],
                ['label' => 'First sample is 9 (every land cell) or second sample is 1 if diagonals join', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. A connected blob is one island. Diagonals stay separate, so the second grid has three islands, not one.\nStep back to when you scored the samples.",
            'outcome' => 'wrong',
            'rewind_to' => 'flood',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Space O(m · n) worst-case stack or queue on a full-land grid. Return the integer count, not a painted grid for the judge.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count starts, 4-way paint; not diagonals, not Surrounded Regions, not every 1', 'next' => 'success'],
                ['label' => '8-connected (include diagonals) is what “adjacent” means here', 'next' => 'wrong_diag'],
            ],
        ],
        'wrong_diag' => [
            'message' => "You are wrong. Adjacent is horizontal or vertical only. Diagonals do not join islands.\nStep back to when you used 8-neighbors.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Each leftover '1' starts an island; flood 4-way and paint to '0'. O(m · n). Not every-cell count, not diagonals, not Surrounded Regions, not Right Side View.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
