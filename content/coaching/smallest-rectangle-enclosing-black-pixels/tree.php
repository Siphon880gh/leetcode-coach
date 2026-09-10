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
            'message' => "Problem: m by n grid of '0'/'1'. One 4-connected black blob. You get one black cell (x, y) (x is the row). Return the area of the smallest axis-aligned rectangle covering every '1'. Seed (0, 2) → 6. Must be faster than a full m by n scan.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Flood-fill from (x, y) like Number of Islands, tracking min/max row and column', 'next' => 'wrong_flood'],
                ['label' => 'Binary-search the four edges of the black band that contains the seed', 'next' => 'bs'],
            ],
        ],
        'wrong_flood' => [
            'message' => "You are wrong here.\nA BFS/DFS from the seed is correct but O(m n). The spec asks for less than that. Maximal Square DP-s every cell — also too slow here.\nStep back to when you flooded the blob.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'bs' => [
            'message' => "One connected blob plus a seed inside it means black rows are a contiguous band including row x, black columns a band including y. Search top in [0, x]: mid row has a '1' → search lower rows; else search toward x. Bottom in [x, m−1] uses an upper-bound mid. Same pair on columns.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return width or height alone, or compare cells as integer 0/1', 'next' => 'wrong_ret'],
                ['label' => 'Area = (bottom − top + 1) times (right − left + 1). Scan a row in O(n), a column in O(m)', 'next' => 'cpx'],
            ],
        ],
        'wrong_ret' => [
            'message' => "You are wrong. The answer is area. Cells are characters — compare to '1', not 1.\nStep back to when you returned a side length or used integer pixels.",
            'outcome' => 'wrong',
            'rewind_to' => 'bs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Checking whether a row is black walks that row. Four binary searches give O(m log n + n log m). [[\"1\"]] is 1.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Four-edge binary search. Not flood fill, not Maximal Square, not O(m n)', 'next' => 'success'],
                ['label' => 'Scan every cell once; n is only 100 so O(m n) is fine', 'next' => 'wrong_scan'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong. Constraints allow 100, but the problem still requires less than O(m n).\nStep back to when you full-scanned.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Binary-search top, bottom, left, right of the single black band. Area is height times width. Faster than flooding. Seed (0, 2) is 6.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
