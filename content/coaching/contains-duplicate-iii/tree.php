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
            'message' => "Problem: true if distinct i, j have abs(i − j) ≤ indexDiff (k) and abs(nums[i] − nums[j]) ≤ valueDiff (t). n up to 10⁵. [1,2,3,1] k=3 t=0 → true. [1,5,9,1,5,9] k=2 t=3 → false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Seen set like 217, or last-index map like 219 (equal values only)', 'next' => 'eq'],
                ['label' => 'Sliding window of the last k values; ordered set (or buckets of width t+1) for a neighbor in [v − t, v + t]', 'next' => 'win'],
            ],
        ],
        'eq' => [
            'message' => "217 ignores distance. 219 needs the same value inside k. Here t can be positive, so 1 and 4 can pair when t is 3. Nested every pair times out at 10⁵.\nWhat extra check is needed?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Index window and value window together. Probe the ordered last-k set for something in [v − t, v + t]', 'next' => 'win'],
                ['label' => 'Return the pair of indices, like Two Sum', 'next' => 'wrong_ret'],
            ],
        ],
        'wrong_ret' => [
            'message' => "You are wrong here.\nThe judge wants true or false, not the indices.\nStep back to when you returned a pair.",
            'outcome' => 'wrong',
            'rewind_to' => 'eq',
            'choices' => [],
        ],
        'win' => [
            'message' => "At v, take the first stored number ≥ v − t. If it exists and is ≤ v + t, true. Then insert v. If i ≥ k, drop nums[i − k]. Bucket twin: width t+1, same or neighbor bucket within t. Use 64-bit so v ± t does not wrap.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,2,3,1] k=3 t=0 true (the two 1s); [1,5,9,1,5,9] k=2 t=3 false', 'next' => 'cpx'],
                ['label' => 'Keep every past value forever; a far-away 1 still pairs when k is 2', 'next' => 'wrong_keep'],
            ],
        ],
        'wrong_keep' => [
            'message' => "You are wrong. Evict nums[i − k] so the ordered set only holds the index window.\nStep back to when you kept the whole history.",
            'outcome' => 'wrong',
            'rewind_to' => 'win',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Ordered set: O(n log k) time, O(k) extra. Buckets: O(n) expected. Boolean only. t=0 still uses width 1 (equal values).\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Window plus nearby values; not 217 anywhere, not 219 equals-only, not nested pairs, not Two Sum indices', 'next' => 'success'],
                ['label' => 'This is 219: t must be 0 or you ignore valueDiff', 'next' => 'wrong_t'],
            ],
        ],
        'wrong_t' => [
            'message' => "You are wrong. III allows values to differ by up to t. 219 is the equal-values special case t=0.\nStep back to when you collapsed this into II.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Index gap ≤ k and value gap ≤ t. Ordered last-k set (or buckets). O(n log k). Not 217, not 219 equals-only, not nested pairs, not returning indices, not keeping unbounded history.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
