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
            'message' => "Problem: two digit arrays nums1, nums2 and k. Largest length-k number using digits from both, keeping order inside each array. [3,4,6,5] and [9,1,2,5,8,3], k = 5 → [9,8,6,5,3]. [6,7] and [6,0,4], k = 5 → [6,7,6,0,4]. Lengths up to 500; k ≤ m + n.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '402 Remove K Digits on the concatenation, or shuffle digits across arrays', 'next' => 'wrong_402'],
                ['label' => 'For each split x from nums1 and k−x from nums2: stack-drop, then suffix-merge', 'next' => 'split'],
            ],
        ],
        'wrong_402' => [
            'message' => "You are wrong here.\nConcatenation invents an order the arrays do not have. Digits from one array cannot be reordered.\nStep back to when you concatenated or shuffled.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'split' => [
            'message' => "x ranges over [max(0, k−n), min(k, m)]. f(nums, t) is the max subsequence of length t: monotonic stack, drop a smaller top while remain = n−t is still positive. Merge the two results like largest-merge: if the current digits tie, compare the rest of each sequence and take from the lexicographically larger suffix ([6,7] vs [6,0,4] picks the first 6 so 7 can follow). Keep the best among all splits.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Merge by only the current digit, or skip the x = 0 split when k ≤ n', 'next' => 'wrong_merge'],
                ['label' => 'O(k² (m + n)). Empty side is allowed', 'next' => 'cpx'],
            ],
        ],
        'wrong_merge' => [
            'message' => "You are wrong. A current-digit tie must look at the leftover suffix. x = 0 is valid when the second array can supply all k digits.\nStep back to when you merged too locally or skipped an empty side.",
            'outcome' => 'wrong',
            'rewind_to' => 'split',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "402 is one array with a drop budget. Here you pick how many digits come from each array, then merge by suffix.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Split, stack-drop, merge by leftover suffix. Not 402 on a concat', 'next' => 'success'],
                ['label' => 'Always take the global k largest digits, then sort them descending', 'next' => 'wrong_sort'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong. Relative order inside each array is required. Sample 1 is not a sorted bag of the five largest digits.\nStep back to when you sorted a bag of digits.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Every split x + (k−x). Max subsequence via a drop stack. Merge by comparing remaining suffixes. Not 402 on a concatenation.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
