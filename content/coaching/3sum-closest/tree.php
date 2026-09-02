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
            'message' => "Problem: 3Sum Closest. nums = [-1,2,1,-4], target = 1 → 2 (because -1+2+1). Return the sum, not the triplet. n ≤ 500.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'List every distinct 3Sum triplet, then pick the one with values nearest target', 'next' => 'list_all'],
                ['label' => 'Sort, fix i, two-pointer the rest, keep the running closest sum', 'next' => 'scan'],
            ],
        ],
        'list_all' => [
            'message' => "This is not 3Sum. You need one sum, and you may assume exactly one best answer. Enumerating every zero-sum triple misses sums that never hit 0.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the triplet [i, j, k] whose values are closest — the judge compares arrays', 'next' => 'wrong_triplet'],
                ['label' => 'For each i, two pointers j, k: if t == target return t; else update ans by |t − target| and move the side that shrinks the gap', 'next' => 'scan'],
            ],
        ],
        'wrong_triplet' => [
            'message' => "You are wrong here.\nThe return type is an integer sum, not an index triple or a value triple.\nStep back to when you chose what to return.",
            'outcome' => 'wrong',
            'rewind_to' => 'list_all',
            'choices' => [],
        ],
        'scan' => [
            'message' => "After sort: [-4,-1,1,2]. i at -4, j and k walk the rest. t = nums[i]+nums[j]+nums[k].\nIf t > target, which pointer moves?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'k moves left — the sum is too large, so drop the large end', 'next' => 'example'],
                ['label' => 'j moves right — a larger middle value might still land closer', 'next' => 'wrong_dir'],
            ],
        ],
        'wrong_dir' => [
            'message' => "You are wrong. On a sorted array, t > target means nums[k] is the one you can still decrease. Moving j only makes t larger.\nStep back to when you chose the pointer move.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'example' => [
            'message' => "[-1,2,1] sums to 2; |2−1| = 1 beats |-4+1+2 − 1| = 2. Exact hits return immediately.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n²) time after sort; extra space O(log n) for the sort', 'next' => 'success'],
                ['label' => 'O(n) because you only need one pass like Container With Most Water', 'next' => 'wrong_linear'],
            ],
        ],
        'wrong_linear' => [
            'message' => "You are wrong. You restart j and k for every i. That is O(n) per fixed i, so O(n²) overall.\nStep back to when you scored the scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort. Fix i. Two pointers: update ans when |t − target| is smaller; return t on an exact hit; move k left if t is high, else j right. Time O(n²).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
