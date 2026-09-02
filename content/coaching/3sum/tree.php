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
            'message' => "Problem: 3Sum. nums = [-1,0,1,2,-1,-4] → [[-1,-1,2],[-1,0,1]]. Distinct value triplets, not index triples. n can be 3000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Triple nested loops over every i < j < k', 'next' => 'brute'],
                ['label' => 'Sort, fix i, then two-sum the remainder with j and k', 'next' => 'sort_scan'],
            ],
        ],
        'brute' => [
            'message' => "O(n³) is too slow at n = 3000, and raw index triples also emit duplicates like [-1,0,1] twice.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hash every pair as you go — skip sorting so you keep original order', 'next' => 'wrong_hash'],
                ['label' => 'Sort first so duplicates sit together, then two pointers for each i', 'next' => 'sort_scan'],
            ],
        ],
        'wrong_hash' => [
            'message' => "You are wrong here.\nAn unsorted hash two-sum still reports the same values more than once. Sorting is what makes skipping duplicates cheap.\nStep back to when you chose how to avoid repeats.",
            'outcome' => 'wrong',
            'rewind_to' => 'brute',
            'choices' => [],
        ],
        'sort_scan' => [
            'message' => "After sort: [-4,-1,-1,0,1,2]. For each i, j = i+1, k = n-1. If nums[i] > 0 you can stop.\nHow do you skip duplicate triplets?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip i when nums[i] equals nums[i-1]; after a hit, skip equal nums[j] and nums[k]', 'next' => 'example'],
                ['label' => 'Never skip equals — [-1,-1,2] is invalid because two values match', 'next' => 'wrong_skip'],
            ],
        ],
        'wrong_skip' => [
            'message' => "You are wrong. Distinct triplets are about the triple of values, not all-different numbers. [-1,-1,2] is required.\nStep back to when you defined uniqueness.",
            'outcome' => 'wrong',
            'rewind_to' => 'sort_scan',
            'choices' => [],
        ],
        'example' => [
            'message' => "i at first -1: pointers find (-1,2) and (0,1). Next i is the second -1 — skip it. [0,0,0] still yields one [0,0,0].\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n²) time after O(n log n) sort; extra space O(1) besides the answer', 'next' => 'success'],
                ['label' => 'O(n log n) total because each pointer only moves once in the whole algorithm', 'next' => 'wrong_nlogn'],
            ],
        ],
        'wrong_nlogn' => [
            'message' => "You are wrong. You restart j and k for every i, so the two-pointer scans are O(n) each and the outer loop is O(n).\nStep back to when you scored the scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort. Fix i (skip duplicates; stop if nums[i] > 0). Two pointers j, k on the rest: move j up if the sum is low, k down if high, record and skip equals on a hit. Time O(n²).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
