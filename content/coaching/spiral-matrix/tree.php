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
            'message' => "Problem: emit every cell of an m×n matrix in clockwise spiral order. [[1,2,3],[4,5,6],[7,8,9]] → [1,2,3,6,9,8,7,4,5]. m,n ≤ 10.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DFS maze: from each cell pick any unvisited neighbor', 'next' => 'maze'],
                ['label' => 'Simulate: dirs (0,1, 0,-1, 0); visit, then turn if the next step is blocked', 'next' => 'sim'],
            ],
        ],
        'maze' => [
            'message' => "A graph walk can branch left too early. The order is a fixed clockwise heading, not any neighbor.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Rotate the matrix 90 degrees in place, then read the first row each time', 'next' => 'wrong_rotate'],
                ['label' => 'Keep heading k; if next (i,j) is out of bounds or vis, k = (k+1) % 4, then step', 'next' => 'sim'],
            ],
        ],
        'wrong_rotate' => [
            'message' => "You are wrong here.\nRotate Image mutates a square in place. This problem is rectangular, asks for a list, and must not require a square.\nStep back to when you reused rotate.",
            'outcome' => 'wrong',
            'rewind_to' => 'maze',
            'choices' => [],
        ],
        'sim' => [
            'message' => "Why mark vis, not only matrix bounds?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The inner ring is still in bounds; without vis you walk into cells you already emitted', 'next' => 'example'],
                ['label' => 'Bounds suffice: you only turn at the outer frame, so the center is never reached twice', 'next' => 'wrong_vis'],
            ],
        ],
        'wrong_vis' => [
            'message' => "You are wrong. After the first loop, the next cell inward is still a legal index. vis (or shrinking walls) is what forces the turn.\nStep back to when you dropped vis.",
            'outcome' => 'wrong',
            'rewind_to' => 'sim',
            'choices' => [],
        ],
        'example' => [
            'message' => "Loop exactly m*n times: append matrix[i][j], mark vis, peek, maybe turn, then always move with the (new) heading. 3×3 yields 1,2,3,6,9,8,7,4,5.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(m·n) time; O(m·n) extra for vis in this writeup (answer excluded)', 'next' => 'success'],
                ['label' => 'O(m+n) because you only walk the perimeter', 'next' => 'wrong_perim'],
            ],
        ],
        'wrong_perim' => [
            'message' => "You are wrong. Every cell is visited once, including the center 5. Time is linear in the whole grid.\nStep back to when you scored only the border.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dirs right/down/left/up. Visit, mark, peek; turn if OOB or vis; then step. Time O(m·n). Not a maze DFS, not Rotate Image, and not the perimeter alone.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
