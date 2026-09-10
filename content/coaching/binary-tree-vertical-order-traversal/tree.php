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
            'message' => "Problem: group values by vertical column, each column top to bottom. Same row and column: left to right. Empty → []. [3,9,20,null,null,15,7] → [[9],[3,15],[20],[7]]. [3,9,8,4,0,1,7] → [[4],[9],[3,0,1],[8],[7]]. Up to 100 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '987: sort same-cell ties by node value, or dump inorder', 'next' => 'wrong_987'],
                ['label' => 'BFS with column offset: root 0, left minus 1, right plus 1', 'next' => 'bfs'],
            ],
        ],
        'wrong_987' => [
            'message' => "You are wrong here.\n987 sorts ties by value. Inorder is not vertical order. Here same row stays left-to-right.\nStep back to when you reused 987 or inorder.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'bfs' => [
            'message' => "Queue (root, 0). Append val into a map by offset. Enqueue left then right. After BFS, emit lists from leftmost offset to rightmost (sorted keys, or min..max). Shallower nodes come first, so no depth sort. DFS twin: store (depth, val) and sort by depth only.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort a column by node value, or skip a column that has a hole above it', 'next' => 'wrong_sort'],
                ['label' => 'O(n) if you walk min..max column. Empty tree is []', 'next' => 'cpx'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong. Ties are left-to-right, not by value. Still emit every column that has nodes.\nStep back to when you sorted values or dropped a column.",
            'outcome' => 'wrong',
            'rewind_to' => 'bfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Right Side View (199) keeps one node per depth. This keeps every node, grouped by column.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'BFS by column, left-to-right ties. Not 987, not inorder', 'next' => 'success'],
                ['label' => 'Return one value per column (the top node only)', 'next' => 'wrong_top'],
            ],
        ],
        'wrong_top' => [
            'message' => "You are wrong. A column can have several nodes, top to bottom. Sample 1’s middle column is [3,15].\nStep back to when you kept only the top.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Column 0 at the root. BFS fills each column top-to-bottom, left-to-right. Emit left to right. Not 987’s value sort.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
