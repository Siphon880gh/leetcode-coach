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
            'message' => "Problem: SnakeGame(width, height, food) then move(U|D|L|R). Start at (0, 0), length 1. Return score, or −1 on wall or self. Food appears one piece at a time. 3×2 board, food (1, 2) then (0, 1): R, D, R, U, L, U → 0, 0, 1, 1, 2, −1. Width and height up to 1e4; about 1e4 moves.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Allocate a height by width grid and rewrite every cell each move', 'next' => 'wrong_grid'],
                ['label' => 'Deque of body cells plus a set. Encode a cell; never allocate the full board', 'next' => 'deque'],
            ],
        ],
        'wrong_grid' => [
            'message' => "You are wrong here. Width and height can be 1e4. A full board wastes memory and is not needed to know occupied cells.\nStep back to when you allocated the whole screen.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'deque' => [
            'message' => "Head at the front of the deque. New head from U/D/L/R. Out of bounds → −1. If the cell is the current food, keep the tail (grow) and advance the food index. Else pop the tail from the deque and the set. Then if the new head is still in the set, the snake bit itself.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Test self-collision before dropping the tail, so sliding into the old tail dies', 'next' => 'wrong_tail'],
                ['label' => 'Drop the tail first on a non-food move. Occupying the cell the tail just left is legal', 'next' => 'food'],
            ],
        ],
        'wrong_tail' => [
            'message' => "You are wrong. The problem checks the body after the move. Sliding into the cell the tail is leaving is legal.\nStep back to when you tested the bite before popping the tail.",
            'outcome' => 'wrong',
            'rewind_to' => 'deque',
            'choices' => [],
        ],
        'food' => [
            'message' => "Only food[idx] is on the board. Eating grows length and score by 1, then the next piece appears. Do not spawn the whole food list. Do not grow on empty cells.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Deque plus set. Tail first, then bite check. One food at a time. O(1) per move', 'next' => 'success'],
                ['label' => 'Put every food cell on the board at t = 0 and grow whenever the head hits any of them', 'next' => 'wrong_food'],
            ],
        ],
        'wrong_food' => [
            'message' => "You are wrong. The next food appears only after the previous is eaten. Spawning all food at once changes the path.\nStep back to when you placed every food up front.",
            'outcome' => 'wrong',
            'rewind_to' => 'food',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Deque of body cells plus a set. On a non-food move, pop the tail first, then die on a wall or the remaining body. Food one piece at a time. Not a full board.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
