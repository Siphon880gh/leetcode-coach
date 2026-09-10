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
            'message' => "Problem: m by n grid of W (wall), E (enemy), and 0 (empty). Place one bomb on a 0. The blast follows that row and column until a wall. Return the most enemies one bomb can kill. First example is 3. WWW / 000 / EEE is 1. m and n up to 500. No empty cell → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'From every empty cell, walk four rays until a wall and count E', 'next' => 'wrong_scan'],
                ['label' => 'Four prefix passes: running E count since the last W, add into a kill grid', 'next' => 'prefix'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong here. At 500 by 500, four rays from every empty cell is about m n times (m plus n) and will time out.\nStep back to when you rescanned from each 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'prefix' => [
            'message' => "Each row left to right then right to left; each column top to bottom then bottom to top. Wall zeros the runner. Enemy increments it. Empty still receives the current total. After four passes, kill[i][j] is how many E a bomb at that cell would hit.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Take the max over every cell, including E and W, or let the count continue through a wall', 'next' => 'wrong_place'],
                ['label' => 'Answer is the max kill among cells that are actually 0. Walls reset the runner to 0', 'next' => 'kind'],
            ],
        ],
        'wrong_place' => [
            'message' => "You are wrong. You may plant only on empty 0. A wall blocks the blast, so the running count must drop to 0 there.\nStep back to when you placed on E/W or counted past a wall.",
            'outcome' => 'wrong',
            'rewind_to' => 'prefix',
            'choices' => [],
        ],
        'kind' => [
            'message' => "This is axis-aligned rays, not a 4-neighbor flood. Enemies on a kill cell include themselves in the prefix, but you ignore those cells when taking the max. No empty 0 → 0.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Four wall-reset prefixes, max on 0. O(m n). Not flood-fill, not per-cell rays', 'next' => 'success'],
                ['label' => 'BFS/DFS from the bomb so the blast spreads to 4-neighbors like a flood', 'next' => 'wrong_flood'],
            ],
        ],
        'wrong_flood' => [
            'message' => "You are wrong. The bomb does not wrap around walls through adjacent empties. Only the same row and column until W.\nStep back to when you flood-filled.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Four running E counts reset at W. Max among empty 0 cells. First example is 3. Not four rays from every 0, not a flood fill.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
