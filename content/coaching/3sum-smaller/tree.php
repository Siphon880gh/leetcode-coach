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
            'message' => "Problem: count index triples i < j < k with nums[i]+nums[j]+nums[k] < target. [-2,0,1,3], target 2 → 2. Empty → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '3Sum (15): skip equal neighbors and list distinct value triples that equal 0', 'next' => 'eq'],
                ['label' => 'Sort, fix i, two-pointer j/k: if sum < target add (k − j) and j += 1; else k -= 1', 'next' => 'tp'],
            ],
        ],
        'eq' => [
            'message' => "15 lists unique values that equal a target. Here you count indices under a strict less-than; repeats still count.\nWhen the current sum is too small, how many k′ work?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Every k′ in (j, k] works because those values are ≤ nums[k]; add k minus j', 'next' => 'tp'],
                ['label' => 'Add 1 and stop at the first valid pair for this i', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong here.\nOne small sum at (j,k) implies a whole window of k′. Adding 1 undercounts.\nStep back to when you stopped at the first pair.",
            'outcome' => 'wrong',
            'rewind_to' => 'eq',
            'choices' => [],
        ],
        'tp' => [
            'message' => "If the sum is ≥ target, shrink k. Skip equal values would undercount indices. n up to 3500 so O(n³) is too slow.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[-2,0,1,3], target 2 → 2 ([-2,0,1] and [-2,0,3])', 'next' => 'cpx'],
                ['label' => 'Perfect Squares: knapsack the triple sums with square coins', 'next' => 'wrong_sq'],
            ],
        ],
        'wrong_sq' => [
            'message' => "You are wrong. Perfect Squares counts squares that add to n. This problem counts index triples under a sum bound.\nStep back to when you swapped problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'tp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n²) after sort. Not 3Sum’s skip-duplicates, not enumerate all triples, not Coin Change.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort, fix i, add k minus j on a small sum, move j; else move k', 'next' => 'success'],
                ['label' => 'Skip equal nums[j] like 3Sum so duplicate values do not count twice', 'next' => 'wrong_skip'],
            ],
        ],
        'wrong_skip' => [
            'message' => "You are wrong. Different indices still count even if values match. Skipping equals undercounts.\nStep back to when you reused 3Sum’s skip.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort. Fix i. Two-pointer the suffix. Small sum: add k − j, then j += 1. Large: k -= 1. Count indices, not unique values. Do not O(n³), skip duplicates, or stop at the first pair.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
