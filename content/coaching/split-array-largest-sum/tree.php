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
            'message' => "Problem: nums length 1 to 1000, values 0 to 1e6, k from 1 to min(50, n). Split into exactly k nonempty contiguous subarrays. Minimize the largest subarray sum. [7,2,5,10,8] k=2 → 18 ([7,2,5] and [10,8]). [1,2,3,4,5] k=2 → 9.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Kadane (53) for one max subarray, or split into k non-contiguous groups', 'next' => 'wrong_53'],
                ['label' => 'Binary search the cap. Left = max(nums), right = total. Greedy pack under that cap', 'next' => 'check'],
            ],
        ],
        'wrong_53' => [
            'message' => "You are wrong here. 53 finds one contiguous max; here every element is used, in order, in k pieces. Non-contiguous groups would violate the subarray requirement.\nStep back to when you used Kadane or rearranged.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'check' => [
            'message' => "check(mid): walk left to right, start a new piece whenever adding x would exceed mid. Count pieces. Feasible iff that count is at most k (you can always merge into fewer pieces by raising the cap). Search the smallest mid that is feasible.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Search from 0, or require the greedy to use exactly k pieces (not at most k)', 'next' => 'wrong_bound'],
                ['label' => 'Left bound is max(nums) because one element cannot split. Feasible means at most k pieces', 'next' => 'kind'],
            ],
        ],
        'wrong_bound' => [
            'message' => "You are wrong. A cap below max(nums) cannot cover the largest element. Using fewer than k pieces is always possible by merging, so at most k is the right test; the binary search then finds the smallest cap that still fits in k.\nStep back to when you searched from 0 or demanded exactly k greedy cuts.",
            'outcome' => 'wrong',
            'rewind_to' => 'check',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Capacity To Ship Packages (1011) is the same binary-search-plus-greedy pack. Paint House / House Robber are DP on houses, not this split. Time O(n log (sum)).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Binary search the cap, greedy pack. [7,2,5,10,8] k=2 → 18. Not 53', 'next' => 'success'],
                ['label' => 'DP over all cut positions without a monotonic check, or allow empty pieces', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. Pieces must be nonempty. The feasibility of a cap is monotonic, so binary search plus a linear greedy walk is enough; you do not need O(n² k) DP unless you want it.\nStep back to when you allowed empty pieces or skipped the monotonic search.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Binary search the largest-piece cap. Greedy pack; feasible means at most k pieces. [7,2,5,10,8] k=2 → 18. Not 53.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
