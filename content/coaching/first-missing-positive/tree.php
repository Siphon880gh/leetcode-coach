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
            'message' => "Problem: smallest positive integer not in nums. Must be O(n) time and O(1) extra. [1,2,0] → 3. [3,4,-1,1] → 2. [7,8,9,11,12] → 1. n up to 1e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort nums, then walk 1, 2, 3, … until a gap', 'next' => 'sort'],
                ['label' => 'Swap each x in [1, n] into index x-1; first i with nums[i] != i+1 is the answer', 'next' => 'swap'],
            ],
        ],
        'sort' => [
            'message' => "Sorting is O(n log n). The constraint forbids that. A hash set of positives then scan k = 1, 2, … is O(n) time but O(n) extra.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The set is fine; O(1) extra only bans recursion, not a Boolean array of size n', 'next' => 'wrong_set'],
                ['label' => 'Use the array itself as the map: while 1 ≤ nums[i] ≤ n and nums[i] != nums[nums[i]-1], swap', 'next' => 'swap'],
            ],
        ],
        'wrong_set' => [
            'message' => "You are wrong here.\nA Boolean array or set of size n is O(n) auxiliary space. The seats have to be nums itself.\nStep back to when you chose extra storage.",
            'outcome' => 'wrong',
            'rewind_to' => 'sort',
            'choices' => [],
        ],
        'swap' => [
            'message' => "Negatives, zeros, and values larger than n are ignored (they cannot sit in a slot 1..n). After placement, if every nums[i] == i+1, what do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'n+1 — the range [1, n] is full, so the missing value is just past n', 'next' => 'example'],
                ['label' => '0 — there is no missing positive inside the array values', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. 0 is not a positive integer. If 1 through n are all present, the smallest missing positive is n+1.\nStep back to when you chose the full-range answer.",
            'outcome' => 'wrong',
            'rewind_to' => 'swap',
            'choices' => [],
        ],
        'example' => [
            'message' => "[3,4,-1,1] seats 3 and 1, leaves a hole at index 1 → 2. [7,8,9,11,12] has nothing in [1, n] → 1. The inner while is amortized O(n): each swap parks a value.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(1) extra (mutate nums in place)', 'next' => 'success'],
                ['label' => 'O(n²) because a while sits inside a for-loop', 'next' => 'wrong_n2'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong. Each successful swap puts a number into its home index and does not unpark it. Total swaps are O(n), not n².\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. For each i, while nums[i] is in [1, n] and not already at index nums[i]-1, swap it there. Then scan for the first nums[i] != i+1; else n+1. Time O(n), extra O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
