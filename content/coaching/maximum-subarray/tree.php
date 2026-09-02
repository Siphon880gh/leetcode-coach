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
            'message' => "Problem: nonempty contiguous subarray with the largest sum. Example: [-2,1,-3,4,-1,2,1,-5,4] → 6 from [4,-1,2,1]. Single [1] → 1. Length up to 1e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Nested loops: try every left and right end and sum the slice', 'next' => 'n2'],
                ['label' => 'Kadane: f = max(f, 0) + x; keep a running max of f', 'next' => 'kadane'],
            ],
        ],
        'n2' => [
            'message' => "O(n²) pairs miss the 1e5 limit. Prefix sums still enumerate every pair of ends.\nWhat is the O(n) idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the max element; a mixed window cannot beat one peak', 'next' => 'wrong_peak'],
                ['label' => 'f[i] = max(f[i-1], 0) + nums[i]; answer is the max f along the scan', 'next' => 'kadane'],
            ],
        ],
        'wrong_peak' => [
            'message' => "You are wrong here.\n[4,-1,2,1] sums to 6, larger than any single cell. Contiguous neighbors can help even after a dip.\nStep back to when you kept only the peak.",
            'outcome' => 'wrong',
            'rewind_to' => 'n2',
            'choices' => [],
        ],
        'kadane' => [
            'message' => "Why reset with max(f, 0) instead of always doing f = f + x?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A negative prefix cannot improve a subarray that starts later, so drop it', 'next' => 'example'],
                ['label' => 'Always keep the whole prefix; negatives cancel later and the total is still best', 'next' => 'wrong_keep'],
            ],
        ],
        'wrong_keep' => [
            'message' => "You are wrong. The array starts at -2. Keeping that prefix forever loses to starting at 4. Drop a running sum that is already negative.\nStep back to when you refused to reset.",
            'outcome' => 'wrong',
            'rewind_to' => 'kadane',
            'choices' => [],
        ],
        'example' => [
            'message' => "Seed ans = f = nums[0] (empty is illegal). Then scan the rest. All-negative arrays must return the least-bad element, not 0.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(1) extra: one pass, two scalars', 'next' => 'success'],
                ['label' => 'O(n) extra for an f array is required to remember every ending', 'next' => 'wrong_space'],
            ],
        ],
        'wrong_space' => [
            'message' => "You are wrong. f[i] depends only on f[i-1], so one variable is enough. The writeup uses O(1) extra space.\nStep back to when you allocated the table.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. ans = f = nums[0]. For each later x: f = max(f, 0) + x; ans = max(ans, f). Time O(n), extra O(1). Not every pair of ends, not max(nums) alone, and not an empty subarray of sum 0.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
