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
            'message' => "Problem: longest path of strictly increasing cells. Four directions; no diagonal, no wrap. [[9,9,4],[6,6,8],[2,1,1]] → 4 (1,2,6,9). One cell → 1. Up to 200 by 200.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '1-D LIS (300), or DFS without a cache, or allow equals / diagonals', 'next' => 'wrong_lis'],
                ['label' => 'Memo DFS: 1 plus the best strictly larger neighbor', 'next' => 'dfs'],
            ],
        ],
        'wrong_lis' => [
            'message' => "You are wrong here.\n300 is a subsequence on a line. Equals do not extend. Diagonals are forbidden. Uncached DFS from every cell is exponential.\nStep back to when you reused 300, skipped the cache, or loosened the move.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "dfs(i, j): if cached, return it. Try four in-bounds neighbors with matrix[x][y] > matrix[i][j]; take max of those dfs values (0 if none); store 1 + that max. Answer is max dfs over all cells. Strict increase means no cycles, so each cell is solved once.\nTopo from small values also works. 2328 counts paths; this wants length.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the path list, or count how many increasing paths (2328)', 'next' => 'wrong_cnt'],
                ['label' => 'O(m n) time and space. Length includes the start cell', 'next' => 'cpx'],
            ],
        ],
        'wrong_cnt' => [
            'message' => "You are wrong. The answer is a length (cell count), not the cells themselves and not a path count.\nStep back to when you returned a list or a count of paths.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "A lone cell is length 1, not 0.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Memo DFS on a DAG. Strict 4-dir. Not 300, not 2328', 'next' => 'success'],
                ['label' => 'Allow wrap-around at the matrix border', 'next' => 'wrong_wrap'],
            ],
        ],
        'wrong_wrap' => [
            'message' => "You are wrong. Moves that leave the grid are invalid. No wrap.\nStep back to when you wrapped around the border.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Memo DFS: 1 plus the best strictly larger neighbor. DAG because values increase. Four directions only. Not 300.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
