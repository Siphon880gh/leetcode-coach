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
            'message' => "Problem: rotated sorted nums, duplicates allowed. Return whether target is present. [2,5,6,0,0,1,2], 0 → true, 3 → false. n ≤ 5000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Same as Search in Rotated Sorted Array: always pick a sorted half from mid vs l, return an index', 'next' => 'one'],
                ['label' => 'Binary search vs nums[r]: if mid equals r, decrement r; else keep the sorted half that can hold target', 'next' => 'dup'],
            ],
        ],
        'one' => [
            'message' => "Problem 33 has distinct values, so one half is always strictly sorted, and it returns an index. Duplicates can make nums[mid] == nums[r], so you cannot tell which side wraps.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Flatten like Search a 2D Matrix — the rotation is one increasing stream', 'next' => 'wrong_flat'],
                ['label' => 'When nums[mid] == nums[r], r -= 1; otherwise the usual rotated-half test', 'next' => 'dup'],
            ],
        ],
        'wrong_flat' => [
            'message' => "You are wrong here.\nA rotation wraps; the 2D-matrix flatten needs each row to start after the previous row ends. That invariant is gone.\nStep back to when you flattened.",
            'outcome' => 'wrong',
            'rewind_to' => 'one',
            'choices' => [],
        ],
        'dup' => [
            'message' => "If nums[mid] > nums[r], [l, mid] is ordered: keep it when nums[l] <= target <= nums[mid]. If nums[mid] < nums[r], the right is ordered. Why not still claim O(log n) always?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'All-equal prefixes force r to walk down one by one; worst case O(n), extra O(1)', 'next' => 'bool'],
                ['label' => 'Duplicates do not change the bound; it stays O(log n) like problem 33', 'next' => 'wrong_log'],
            ],
        ],
        'wrong_log' => [
            'message' => "You are wrong. The follow-up is exactly this: equal mid and r give no half to drop, so you only shrink r by 1. Worst case linear.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'dup',
            'choices' => [],
        ],
        'bool' => [
            'message' => "When l meets r, check equality.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'true iff nums[l] == target — a boolean, not the index from problem 33', 'next' => 'success'],
                ['label' => 'The index l, or -1, like Search in Rotated Sorted Array', 'next' => 'wrong_idx'],
            ],
        ],
        'wrong_idx' => [
            'message' => "You are wrong. This signature is boolean. Problem 33 returns the index.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'bool',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Compare mid to nums[r]. Equal → r--. Greater → left half sorted; less → right half sorted. Keep the half that can contain target. Return nums[l] == target. Worst case O(n) because of duplicates — not problem 33’s strict O(log n), not a 2D flatten.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
