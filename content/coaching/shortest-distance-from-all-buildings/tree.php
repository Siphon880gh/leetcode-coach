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
            'message' => "Problem: m by n grid of 0 (empty, passable), 1 (building), 2 (obstacle). Place a house on a 0 that 4-walks to every building; minimize the sum of those path lengths. Impossible → −1. Sample [[1,0,2,0,1],[0,0,0,0,0],[0,0,1,0,0]] → 7. [[1,0]] → 1. [[1]] → −1. m, n up to 50.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '296 median (Manhattan, no walls), or BFS from every empty cell', 'next' => 'wrong_296'],
                ['label' => 'BFS from each building into 0-cells; sum dist and count hits', 'next' => 'bfs'],
            ],
        ],
        'wrong_296' => [
            'message' => "You are wrong here.\n296 has no walls; a 2 can block the taxicab path. BFS from every 0 repeats the same work when empty cells outnumber buildings.\nStep back to when you used Manhattan or started from land.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'bfs' => [
            'message' => "Count buildings B. For each 1, BFS only into cells that are 0 (not through 1 or 2). First visit in that BFS: add the layer distance into dist[r][c] and increment cnt[r][c]. After every building, scan empty cells with cnt == B; take the min dist. None → −1.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Walk through 1 or 2, or pick a cell that only some buildings can reach', 'next' => 'wrong_block'],
                ['label' => 'O(B m n). House sits on a 0, never on a 1', 'next' => 'cpx'],
            ],
        ],
        'wrong_block' => [
            'message' => "You are wrong. Buildings and obstacles block. cnt must equal B or a landlocked 0 only sees some buildings.\nStep back to when you walked through walls or skipped the hit count.",
            'outcome' => 'wrong',
            'rewind_to' => 'bfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "286 Walls and Gates BFS from every gate, but you do not need to reach every building. 296 is median. Here every 1 must hit the chosen 0.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'BFS from each 1, min dist among 0-cells with cnt == B, else −1', 'next' => 'success'],
                ['label' => 'Return 0 if there is only one building (house on that 1)', 'next' => 'wrong_on1'],
            ],
        ],
        'wrong_on1' => [
            'message' => "You are wrong. The house must sit on empty land. [[1]] has no 0, so the answer is −1.\nStep back to when you built on a building.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. BFS from each building into empty cells. Min dist among cells hit by every building. Not 296 Manhattan. Impossible is −1.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
