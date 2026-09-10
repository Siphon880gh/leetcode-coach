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
            'message' => "Problem: fill each empty room (INF) with distance to the nearest gate (0). Walls are −1. Unreachable stays INF. In place.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'BFS from every empty room to the nearest gate', 'next' => 'wrong_rooms'],
                ['label' => 'Multi-source BFS: enqueue every gate, then expand into INF', 'next' => 'ms'],
            ],
        ],
        'wrong_rooms' => [
            'message' => "You are wrong here.\nA BFS per empty cell is O((m n)²) at 250 by 250. Gates as sources visit each cell once.\nStep back to when you started from rooms.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'ms' => [
            'message' => "Enqueue all 0s. Each level, d += 1. For a 4-neighbor still INF, write d and enqueue. Do not enter −1 or a cell already filled (it already has a closer or equal gate).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DFS from a gate: a long path can paint first and miss a nearer gate', 'next' => 'wrong_dfs'],
                ['label' => 'O(m n) time, O(m n) queue. First touch is shortest. Unreachable stays INF', 'next' => 'cpx'],
            ],
        ],
        'wrong_dfs' => [
            'message' => "You are wrong. DFS is not shortest-path. A farther gate can mark a room before a closer one unless you keep taking mins everywhere. BFS first-touch is enough.\nStep back to when you used DFS.",
            'outcome' => 'wrong',
            'rewind_to' => 'ms',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "In place. INF is 2³¹ − 1. Compare to that, not to a small sentinel.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Multi-source BFS from gates. Not per-room BFS, not DFS, not walking through walls', 'next' => 'success'],
                ['label' => 'Walk through −1 walls if it shortens the path', 'next' => 'wrong_wall'],
            ],
        ],
        'wrong_wall' => [
            'message' => "You are wrong. −1 is an obstacle. Neighbors that are walls stay −1; only INF rooms get a distance.\nStep back to when you entered walls.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Queue every gate. Expand into INF; first write is nearest-gate distance. Walls stay −1. Unreachable stays INF.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
