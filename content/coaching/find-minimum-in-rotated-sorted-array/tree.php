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
            'message' => "Problem: unique ascending array rotated 1..n times; return the minimum in O(log n). [3,4,5,1,2] → 1. [4,5,6,7,0,1,2] → 0. [11,13,15,17] → 11. n ≤ 5000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Linear min(), Search in Rotated Sorted Array for a target, Rotated II duplicates, or product-subarray DP', 'next' => 'linear'],
                ['label' => 'Binary search vs the last value: if mid is above the last, the min is strictly right of mid', 'next' => 'bin'],
            ],
        ],
        'linear' => [
            'message' => "min() is O(n). Problem 33 finds a target index. Problem 81 allows duplicates. Product subarray is DP. Here you only need the rotation’s valley.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Find the target 0, or sort then take nums[0]', 'next' => 'wrong_target'],
                ['label' => 'Compare nums[mid] to nums[-1] and shrink to the half that still contains the min', 'next' => 'bin'],
            ],
        ],
        'wrong_target' => [
            'message' => "You are wrong here.\nThe min is not always 0. Sorting costs extra and is not O(log n). You are not searching for a given target.\nStep back to when you reused Search in Rotated Sorted Array.",
            'outcome' => 'wrong',
            'rewind_to' => 'linear',
            'choices' => [],
        ],
        'bin' => [
            'message' => "l, r = 0, n-1. While l < r: mid = (l+r)//2. If nums[mid] > nums[-1], l = mid+1; else r = mid. Return nums[l]. Else includes equality so a fully rotated-n array (already sorted) keeps shrinking r toward 0.\nWhy r = mid, not mid-1, when nums[mid] <= last?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'mid itself can be the minimum; dropping it would skip the answer', 'next' => 'ret'],
                ['label' => 'Always drop mid; the min is never at mid', 'next' => 'wrong_drop'],
            ],
        ],
        'wrong_drop' => [
            'message' => "You are wrong. When mid sits on the valley, nums[mid] <= last and mid is the answer. r = mid keeps it.\nStep back to when you discarded mid.",
            'outcome' => 'wrong',
            'rewind_to' => 'bin',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Time O(log n), extra O(1). Values are unique, so you do not need Rotated II’s shrink-when-equal. [11,13,15,17] never has mid > last, so l stays 0.\nWhat does [3,4,5,1,2] return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '1 — the valley after 5', 'next' => 'success'],
                ['label' => '3 (the first cell) or 0 like the second sample', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. The first sample’s min is 1, not the original 3 and not the other example’s 0.\nStep back to when you mixed the samples.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Binary search vs last: mid > last → go right; else keep mid. Return nums[l]. O(log n). Not linear min, not Search I’s target, not Rotated II, not product DP. Unique values.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
