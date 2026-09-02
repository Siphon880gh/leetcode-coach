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
            'message' => "Problem: nums is strictly increasing. Return the index of target, or where it would be inserted. [1,3,5,6], target = 5 → 2; target = 2 → 1; target = 7 → 4. O(log n). n up to 10^4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Scan until nums[i] >= target, else return n', 'next' => 'linear'],
                ['label' => 'Binary search for the first i with nums[i] >= target (lower bound)', 'next' => 'lb'],
            ],
        ],
        'linear' => [
            'message' => "A scan is O(n). You want the same index lower_bound would return, in log time.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Binary-search as if this were “find or return -1”', 'next' => 'wrong_neg'],
                ['label' => 'l, r = 0, n; while l < r, if nums[mid] >= target then r = mid else l = mid+1; return l', 'next' => 'lb'],
            ],
        ],
        'wrong_neg' => [
            'message' => "You are wrong here.\nMissing target is not -1. [1,3,5,6] with 2 inserts at 1; with 7 inserts at 4 (past the last index).\nStep back to when you chose the not-found result.",
            'outcome' => 'wrong',
            'rewind_to' => 'linear',
            'choices' => [],
        ],
        'lb' => [
            'message' => "The half-open range is [l, r) with r starting at n, not n-1.\nWhy include n?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'If every nums[i] < target, the insertion index is n', 'next' => 'example'],
                ['label' => 'r = n-1 is enough because you never insert after the last element', 'next' => 'wrong_end'],
            ],
        ],
        'wrong_end' => [
            'message' => "You are wrong. target = 7 in [1,3,5,6] must return 4, which is n. A closed right bound of n-1 cannot name that slot.\nStep back to when you chose the right endpoint.",
            'outcome' => 'wrong',
            'rewind_to' => 'lb',
            'choices' => [],
        ],
        'example' => [
            'message' => "[1,3,5,6]: 5 shrinks onto index 2; 2 lands at 1; 0 lands at 0; 7 leaves l = 4. Found and missing share the same loop because “first >= target” is the insert index either way.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(log n) time, O(1) extra space', 'next' => 'success'],
                ['label' => 'O(n) when target is larger than nums[-1], because you walk to the end', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. The loop still halves [l, r). Large targets just finish with l = n after O(log n) steps.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. lower_bound: first index i with nums[i] >= target, or n. Half-open [l, n). Time O(log n), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
