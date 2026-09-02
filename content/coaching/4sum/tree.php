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
            'message' => "Problem: 4Sum. nums = [1,0,-1,0,-2,2], target = 0 → [[-2,-1,1,2],[-2,0,0,2],[-1,0,0,1]]. Unique value quads. n ≤ 200; values can be 10^9.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Four nested loops over every a < b < c < d', 'next' => 'brute'],
                ['label' => 'Sort, fix i then j, two-pointer the remaining pair to target', 'next' => 'scan'],
            ],
        ],
        'brute' => [
            'message' => "O(n^4) is too slow at n = 200, and raw index tuples also dump duplicates. 4Sum is 3Sum with one extra outer index.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Call 3Sum once on the whole array and ignore target', 'next' => 'wrong_3sum'],
                ['label' => 'Sort; skip duplicate i and j; k, l walk the suffix like 3Sum', 'next' => 'scan'],
            ],
        ],
        'wrong_3sum' => [
            'message' => "You are wrong here.\nThe four numbers must sum to target, not to 0. Reuse the 3Sum pattern, not the 3Sum answer set.\nStep back to when you chose the reduction.",
            'outcome' => 'wrong',
            'rewind_to' => 'brute',
            'choices' => [],
        ],
        'scan' => [
            'message' => "i from 0 to n-4, j from i+1 to n-3, k = j+1, l = n-1. Skip i if nums[i] equals nums[i-1]. Skip j only when j > i+1 and nums[j] equals nums[j-1].\nWhy keep the first j after a given i even if it equals nums[i]?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[2,2,2,2] with target 8 needs four equal values — the first j is a new pair slot, not a duplicate of a prior j', 'next' => 'example'],
                ['label' => 'Skip every equal neighbor including j = i+1, or you will emit duplicate quads', 'next' => 'wrong_skip'],
            ],
        ],
        'wrong_skip' => [
            'message' => "You are wrong. Skipping j = i+1 when the values match drops [2,2,2,2]. Duplicates are same-index-role repeats, not equal numbers.\nStep back to when you defined uniqueness.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'example' => [
            'message' => "Sum x with a 64-bit integer: four times 10^9 overflows 32-bit. If x < target, k++; if x > target, l--; on a hit, record and skip equal k, l.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n^3) time after sort; extra space O(log n) for the sort', 'next' => 'success'],
                ['label' => 'O(n^2) like 3Sum because the two-pointer scan is still linear overall', 'next' => 'wrong_n2'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong. Two nested fixes (i and j) times an O(n) pointer walk is O(n^3).\nStep back to when you scored the scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort. Fix i then j (skip duplicates; keep the first j after i). Two pointers on the rest toward target; add 64-bit sums. Time O(n^3).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
