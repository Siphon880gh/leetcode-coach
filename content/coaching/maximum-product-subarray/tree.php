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
            'message' => "Problem: nonempty contiguous subarray with the largest product. [2,3,-2,4] → 6 from [2,3]. [-2,0,-1] → 0, not 2, because [-2,-1] is not a subarray. n ≤ 2e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sum Kadane (drop a negative prefix), Reverse Words, Jump Game farthest, or product of the whole array', 'next' => 'sum'],
                ['label' => 'Keep both max and min product ending here; a negative times the min can become the max', 'next' => 'both'],
            ],
        ],
        'sum' => [
            'message' => "Sum Kadane drops a negative prefix. Here a negative can flip a tiny product into a large one later. Jump Game and Reverse Words are different problems. The whole array may include a 0 or extra negatives.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only track the running max product, like sum Kadane’s one scalar', 'next' => 'wrong_one'],
                ['label' => 'At each x, new max and min among x, oldmax*x, and oldmin*x', 'next' => 'both'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong here.\nAfter -2 in [2,3,-2,4], the max ending is -2, but the min ending is -6. Then *4 turns -6 into -24 and also 4 itself; you still need the min from the previous step.\nStep back to when you dropped the min.",
            'outcome' => 'wrong',
            'rewind_to' => 'sum',
            'choices' => [],
        ],
        'both' => [
            'message' => "ans = f = g = nums[0]. For each later x, snapshot ff, gg then f = max(x, ff*x, gg*x) and g = min(x, ff*x, gg*x); ans = max(ans, f). Snapshot so both updates see the old pair.\nWhy include x alone?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A 0 (or a fresh start) must reset the product; you may begin a new subarray at x', 'next' => 'ret'],
                ['label' => 'Always multiply; never start over, even after 0', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. After 0 the product is 0. The next number starts a new subarray. That is why x is a candidate by itself.\nStep back to when you refused to reset.",
            'outcome' => 'wrong',
            'rewind_to' => 'both',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Time O(n), extra O(1). Subarray must be contiguous, so [-2,0,-1] cannot pair -2 with -1. Answer fits 32-bit.\nWhat does [2,3,-2,4] return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '6 — [2,3]; later 4 alone is 4, and 3*(-2)*4 is -24', 'next' => 'success'],
                ['label' => '24 from skipping -2, or 0 like the second sample', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. Skipping -2 is not a subarray. The first sample is 6, not 0.\nStep back to when you mixed the samples or dropped contiguity.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Track max and min product ending here; snapshot before both updates; include x to reset. O(n). Not sum Kadane, not Jump Game, not Reverse Words, not non-contiguous pairing, not whole-array product.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
