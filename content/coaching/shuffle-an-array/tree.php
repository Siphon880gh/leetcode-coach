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
            'message' => "Problem: nums unique ints, length 1 to 50. reset returns the original order. shuffle returns one permutation; every permutation equally likely. At most 1e4 mixed calls. Example [1, 2, 3]: shuffle is some permutation, reset is [1, 2, 3].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Enumerate all permutations and pick one, or shuffle the stored original in place so reset is gone', 'next' => 'wrong_enum'],
                ['label' => 'Keep a copy of nums for reset; Fisher–Yates on a working array', 'next' => 'fy'],
            ],
        ],
        'wrong_enum' => [
            'message' => "You are wrong here. Generating every permutation is factorial time even at n=50. If you shuffle the only copy, reset cannot restore the constructor input.\nStep back to when you enumerated or mutated the original.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'fy' => [
            'message' => "Store original as a copy of nums. reset copies original back. shuffle: for i from 0 through n−1, pick j uniformly in [i, n) and swap nums[i] with nums[j]. After i is fixed, later steps never touch it, so each remaining suffix is a uniform permutation.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Pick j uniformly in [0, n) every step, including already-placed prefixes', 'next' => 'wrong_bias'],
                ['label' => 'Always draw j from the remaining suffix [i, n)', 'next' => 'kind'],
            ],
        ],
        'wrong_bias' => [
            'message' => "You are wrong. Drawing from the whole array each step is not uniform. Some permutations show up more often than others.\nStep back to when you drew j from [0, n).",
            'outcome' => 'wrong',
            'rewind_to' => 'fy',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Insert Delete GetRandom (380) samples one member of a bag. Linked List Random Node (382) is a reservoir of size 1. Here you need a full permutation plus reset of the constructor input.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy for reset. Fisher–Yates. [1,2,3] reset is [1,2,3]. Not 380', 'next' => 'success'],
                ['label' => 'Skip the original copy, or treat shuffle as getRandom of one index', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. Without a stored original, reset has nothing to restore. One random index is not a shuffle of the whole array.\nStep back to when you skipped the copy or used 380.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Keep original for reset. shuffle swaps i with a uniform index in [i, n). [1,2,3] reset → [1,2,3]. Not 380.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
