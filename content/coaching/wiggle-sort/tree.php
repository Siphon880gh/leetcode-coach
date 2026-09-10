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
            'message' => "Problem: reorder nums in place so nums[0] ≤ nums[1] ≥ nums[2] ≤ …. [3,5,2,1,6,4] may become [3,5,1,6,2,4]. Equals are allowed.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Wiggle Sort II: strict peaks via median and virtual indices', 'next' => 'wrong_ii'],
                ['label' => 'One pass: swap when the adjacent pair breaks the wave', 'next' => 'pass'],
            ],
        ],
        'wrong_ii' => [
            'message' => "You are wrong here.\n324 needs strict < > < > and a different construction. 280 allows ≤ and ≥. The sample [6,6,5,6,3,8] can stay.\nStep back to when you imported II’s median trick.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'pass' => [
            'message' => "For i from 1: odd i needs a peak (nums[i] ≥ nums[i−1]); even i needs a valley (nums[i] ≤ nums[i−1]). If the pair is wrong, swap those two. A swap cannot break the previous pair.\nHow do you ship it?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort, then interleave small and large from both ends (O(n log n) only)', 'next' => 'sort_ok'],
                ['label' => 'In-place swaps as above; O(n) time, O(1) extra', 'next' => 'cpx'],
            ],
        ],
        'sort_ok' => [
            'message' => "Sort then pick from both ends is valid but misses the O(n) follow-up. The adjacent swap already works without sorting.\nReady?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Switch to the linear adjacent swap', 'next' => 'cpx'],
                ['label' => 'Return a new array; leave nums unchanged', 'next' => 'wrong_copy'],
            ],
        ],
        'wrong_copy' => [
            'message' => "You are wrong. The API is void: modify nums in place. Do not allocate a second answer array as the required result.\nStep back to when you returned a copy.",
            'outcome' => 'wrong',
            'rewind_to' => 'sort_ok',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(1) extra. Equals do not swap. Other valid waves exist; any one is fine.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'In-place adjacent swap. Not II, not a required full sort, not a new array', 'next' => 'success'],
                ['label' => 'Require strict inequalities; swap even when equal', 'next' => 'wrong_strict'],
            ],
        ],
        'wrong_strict' => [
            'message' => "You are wrong. 280 uses ≤ and ≥. Equal neighbors already satisfy the wave; swapping equals is unnecessary and is not the spec.\nStep back to when you required strict peaks.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One pass: at odd i swap if smaller than the previous; at even i swap if larger. In place. Not Wiggle Sort II, not a required sort.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
