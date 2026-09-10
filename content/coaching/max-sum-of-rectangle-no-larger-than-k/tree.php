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
            'message' => "Problem: m by n matrix (up to 100) and integer k. Return the largest rectangle sum that is still ≤ k. A valid rectangle is guaranteed. [[1, 0, 1], [0, -2, 3]], k = 2 → 2 (the right 2 by 2). [[2, 2, -1]], k = 3 → 3. Values can be negative.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Enumerate every left, right, top, bottom bound and sum each rectangle from scratch', 'next' => 'wrong_brute'],
                ['label' => 'Fix two rows, compress each column into a 1D strip, then max subarray sum ≤ k', 'next' => 'strip'],
            ],
        ],
        'wrong_brute' => [
            'message' => "You are wrong here. Four nested bounds plus a nested sum is far too slow at 100 by 100, even if a rectangle ≤ k exists.\nStep back to when you brute-forced all four edges.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'strip' => [
            'message' => "For the 1D strip, walk a running prefix s. Keep earlier prefixes in a sorted set, seeded with 0. For each s, take the smallest stored prefix ≥ s−k (lower bound / ceiling). If it exists, s minus that prefix is a candidate. Then insert s.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Run Kadane only: the unrestricted max subarray, ignore the cap k', 'next' => 'wrong_kadane'],
                ['label' => 'Ceiling of s−k in the ordered prefixes. Same family as 560, but ≤ k not equals k', 'next' => 'kind'],
            ],
        ],
        'wrong_kadane' => [
            'message' => "You are wrong. Kadane can overshoot k, and negatives mean a smaller subarray may be the one that still fits under k.\nStep back to when you dropped the ordered prefixes.",
            'outcome' => 'wrong',
            'rewind_to' => 'strip',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Follow-up: if rows dwarf columns, enumerate left/right columns instead so the log factor sits on the shorter side. Seed the set with 0 so a prefix that itself is ≤ k is allowed.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Row pairs, then prefix ceiling. Swap axes if columns are shorter. Not Kadane, not 4-bound brute', 'next' => 'success'],
                ['label' => 'Require an exact key s−k like 560, and skip seeding 0', 'next' => 'wrong_exact'],
            ],
        ],
        'wrong_exact' => [
            'message' => "You are wrong. You want the smallest prefix at least s−k, not only an exact hit. Missing 0 drops subarrays that start at the left of the strip.\nStep back to when you required equals-k or skipped the 0 seed.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Fix two rows, 1D prefix ceiling of s−k, seed 0. [[1, 0, 1], [0, -2, 3]], k = 2 → 2. Not Kadane alone, not every 4-bound brute.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
