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
            'message' => "Problem: iterator over v1 and v2 that returns elements alternately. [1,2] and [3,4,5,6] → 1,3,2,4,5,6. One empty list still yields the other.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Flatten 2D Vector: drain all of v1, then all of v2', 'next' => 'wrong_251'],
                ['label' => 'Round-robin: one cursor per list; skip a list that is spent', 'next' => 'cycle'],
            ],
        ],
        'wrong_251' => [
            'message' => "You are wrong here.\n251 walks rows in order, so [1,2] then [3,4,5,6] becomes 1,2,3,4,5,6. Zigzag needs 1,3,2,4,5,6.\nStep back to when you concatenated the lists.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'cycle' => [
            'message' => "vectors = [v1, v2], indexes start at 0, cur = 0, size = 2. hasNext: from start = cur, while this list is spent, cur = (cur + 1) mod size; if you wrap to start, return false. next: emit vectors[cur][indexes[cur]], bump that index, then cur = (cur + 1) mod size.\nFollow-up?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Same cycle for k lists, or a queue of lists that still have items', 'next' => 'cpx'],
                ['label' => 'Assume both lists have the same length so you never skip', 'next' => 'wrong_len'],
            ],
        ],
        'wrong_len' => [
            'message' => "You are wrong. Lengths may differ and one list may be empty. hasNext must skip a spent list instead of assuming equal length.\nStep back to when you required equal lengths.",
            'outcome' => 'wrong',
            'rewind_to' => 'cycle',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Amortized O(1) per next/hasNext. Space O(k) indices (k = 2 here).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Cycle and skip spent lists. Not 251, not concatenate, not equal-length only', 'next' => 'success'],
                ['label' => 'Zigzag Conversion (6): write the values into a raster of rows', 'next' => 'wrong_6'],
            ],
        ],
        'wrong_6' => [
            'message' => "You are wrong. Problem 6 is a string written in rows. This is an iterator that round-robins sequences.\nStep back to when you imported Zigzag Conversion.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One index per list, cycle cur, skip spent lists in hasNext. Extends to k lists with the same loop or a queue. Not Flatten 2D Vector.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
