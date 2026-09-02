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
            'message' => "Problem: nums is ascending then possibly left-rotated; values are distinct. Return the index of target, or -1. [4,5,6,7,0,1,2], target = 0 → 4. Must be O(log n). n up to 5000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Scan left to right until you hit target', 'next' => 'linear'],
                ['label' => 'Binary search: at mid, one side is sorted; keep the side that can contain target', 'next' => 'bin'],
            ],
        ],
        'linear' => [
            'message' => "A scan is O(n). The bound is O(log n), so you still binary-search — the rotation only changes how you choose a half.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort nums, then ordinary binary search', 'next' => 'wrong_sort'],
                ['label' => 'If nums[l] <= nums[mid], [l, mid] has no wrap and is sorted; else [mid, r] is', 'next' => 'bin'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong here.\nSorting costs O(n log n) and destroys the original indices you must return.\nStep back to when you chose how to beat a linear scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'linear',
            'choices' => [],
        ],
        'bin' => [
            'message' => "Suppose nums[l] <= nums[mid], so [l, mid] is sorted. Where does target go?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'If nums[l] <= target <= nums[mid], drop the right half; otherwise drop [l, mid]', 'next' => 'example'],
                ['label' => 'Always drop the rotated half — target cannot sit past the wrap', 'next' => 'wrong_drop'],
            ],
        ],
        'wrong_drop' => [
            'message' => "You are wrong. [4,5,6,7,0,1,2], target = 0 lives in the rotated half. You only drop a half when target is outside that half’s sorted range.\nStep back to when you chose which half to keep.",
            'outcome' => 'wrong',
            'rewind_to' => 'bin',
            'choices' => [],
        ],
        'example' => [
            'message' => "[4,5,6,7,0,1,2], target = 0: mid lands in 4..7, which is sorted and does not contain 0, so search the right. Symmetric: if [mid, r] is the sorted side, keep it only when nums[mid] < target <= nums[r]. When l meets r, return l if nums[l] == target else -1.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(log n) time, O(1) extra space', 'next' => 'success'],
                ['label' => 'O(n): you must scan once to find the rotation index k first', 'next' => 'wrong_k'],
            ],
        ],
        'wrong_k' => [
            'message' => "You are wrong. You never need k as an explicit scan. Each mid already tells you which side is sorted.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Binary search. The half with nums[l] <= nums[mid] is sorted; keep it iff target sits in that closed range, else search the other half. Time O(log n), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
