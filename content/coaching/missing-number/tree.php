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
            'message' => "Problem: nums has n distinct values from 0..n; return the missing one. [3,0,1] → 2. [0,1] → 2. Follow-up: O(n) time, O(1) extra.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hash set of 0..n, or First Missing Positive seating at index x−1', 'next' => 'set'],
                ['label' => 'XOR every index with nums[i], starting ans at n so the range 0..n is covered', 'next' => 'xor'],
            ],
        ],
        'set' => [
            'message' => "A set is O(n) extra. First Missing Positive mutates and hunts 1..n+1, not a hole in 0..n.\nWhat is the O(1)-extra idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Find the Duplicate Number: Floyd on nums[i] as next', 'next' => 'wrong_dup'],
                ['label' => 'XOR cancels pairs. Present values cancel their indices; leftover is missing', 'next' => 'xor'],
            ],
        ],
        'wrong_dup' => [
            'message' => "You are wrong here.\n287 has n+1 values in 1..n and one extra copy. Here one value from 0..n is absent.\nStep back to when you reused Floyd.",
            'outcome' => 'wrong',
            'rewind_to' => 'set',
            'choices' => [],
        ],
        'xor' => [
            'message' => "ans = n; for i, v in nums: ans ^= i ^ v. Gauss twin: n (n + 1) / 2 minus sum(nums).\nWhy start at n, not 0?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Indices only give 0..n−1. XOR n so the full range is in the fold. If n is missing, that is the leftover', 'next' => 'cpx'],
                ['label' => 'Skip XOR-ing n; start at 0. If 0 is in the array it cannot be missing anyway', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. [0,1] is missing 2, which is n. Without XOR-ing n (or enumerating from 1), 0 and 1 cancel and you return 0.\nStep back to when you dropped n.",
            'outcome' => 'wrong',
            'rewind_to' => 'xor',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(1) extra. [3,0,1] → 2. Do not assume 0 is the hole.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'XOR 0..n with the array (or Gauss subtract). Not a set, not 41, not 287', 'next' => 'success'],
                ['label' => 'Always return 0 because the range starts at 0', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. 0 is often present. [3,0,1] is missing 2.\nStep back to when you assumed 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. ans starts at n; XOR i and nums[i]. Pairs cancel. Gauss sum is the same answer. Not a hash set, not First Missing Positive, not Floyd duplicate.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
