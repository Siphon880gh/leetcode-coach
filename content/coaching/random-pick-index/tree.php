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
            'message' => "Problem: nums length 1 to 2e4, values any 32-bit int, duplicates allowed. pick(target) must return an index i with nums[i] equal to target; target is guaranteed to appear. Each matching index equally likely. At most 1e4 picks. [1,2,3,3,3] pick(3) is 2, 3, or 4; pick(1) is 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always return the first match, or shuffle the whole array on every pick', 'next' => 'wrong_first'],
                ['label' => 'Scan matches with reservoir sampling (or pre-group indexes if extra space is ok)', 'next' => 'res'],
            ],
        ],
        'wrong_first' => [
            'message' => "You are wrong here. The first 3 in [1,2,3,3,3] is index 2, but 3 and 4 must be just as likely. Shuffling the whole array on every pick is O(n log n) extra work and is not uniform over matches only.\nStep back to when you returned the first hit or shuffled nums.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'res' => [
            'message' => "Reservoir: n starts at 0. For each index i whose value is target, n += 1, then replace ans with i when a uniform roll in 1..n equals n (probability 1/n). After the scan, every match has probability 1/count. An index map built in the constructor also works; the follow-up is the one-pass scan with O(1) extra space.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Roll 1..length(nums) instead of 1..match-count, or use 0..n-1 and never hit n', 'next' => 'wrong_roll'],
                ['label' => 'On the k-th match, keep it with probability 1/k. Ignore non-matches', 'next' => 'kind'],
            ],
        ],
        'wrong_roll' => [
            'message' => "You are wrong. Probability is 1/k among matches so far, not 1/n of the full array. randint(1, k) equals k is the keep test; an exclusive 0..k-1 roll never equals k.\nStep back to when you rolled against the wrong range.",
            'outcome' => 'wrong',
            'rewind_to' => 'res',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Linked List Random Node (382) is the same reservoir on a list. Insert Delete GetRandom (380) needs unique values and a map, not pick-by-value with duplicates.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reservoir on matches. pick(3) is 2, 3, or 4 equally. Not 380', 'next' => 'success'],
                ['label' => 'Pick a random nums value, or require the array to have unique entries', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. The API picks an index for a given target, and duplicates are the whole point. Uniqueness is 380, not this problem.\nStep back to when you picked a value or banned duplicates.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. On the k-th match, replace with probability 1/k. [1,2,3,3,3] pick(3) → 2, 3, or 4. Not 380.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
