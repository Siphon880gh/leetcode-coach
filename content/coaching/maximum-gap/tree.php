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
            'message' => "Problem: max difference between successive elements after sorting. n < 2 → 0. Must be linear time and linear extra space. [3,6,9,1] → 3. [10] → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Comparison sort then adjacent diffs, Missing Ranges holes, or Find Peak', 'next' => 'sort'],
                ['label' => 'Bucket by (mx-mi)/(n-1); the answer is a jump between nonempty buckets', 'next' => 'buck'],
            ],
        ],
        'sort' => [
            'message' => "Sort-then-scan is O(n log n). Missing Ranges lists every hole as [lo,hi], not one integer. Find Peak returns an index.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The max gap can sit inside one bucket if you only keep min and max per bucket', 'next' => 'wrong_in'],
                ['label' => 'Pigeonhole: bucket width is that average gap, so the max successive gap is between buckets', 'next' => 'buck'],
            ],
        ],
        'wrong_in' => [
            'message' => "You are wrong here.\nInside a bucket, two values differ by less than the bucket width, which is already the even-spread lower bound. Empty buckets are skipped; you compare this min to the previous nonempty max.\nStep back to when you hunted inside a bucket.",
            'outcome' => 'wrong',
            'rewind_to' => 'sort',
            'choices' => [],
        ],
        'buck' => [
            'message' => "bucket_size = max(1, (mx-mi)//(n-1)). Put each v in i = (v-mi)//bucket_size and keep min/max. Walk buckets; skip empties (min > max); ans = max(ans, curmin - prev); prev = curmax.\nOn [3,6,9,1], mi=1, mx=9, n=4, size=2. Sorted successive gaps include 3. What is ans?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '3 — jumps 1→3, 3→6, 6→9; the largest is 3', 'next' => 'ans'],
                ['label' => '8 as mx-mi, or 0 like the single-element sample', 'next' => 'wrong_span'],
            ],
        ],
        'wrong_span' => [
            'message' => "You are wrong. Successive after sorting, not min vs max of the whole array. [10] is n < 2, a different sample.\nStep back to when you scored [3,6,9,1].",
            'outcome' => 'wrong',
            'rewind_to' => 'buck',
            'choices' => [],
        ],
        'ans' => [
            'message' => "Time O(n). [10] returns 0. Not comparison sort, not Missing Ranges, not Find Peak.\nWhat is [10]?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '0 — fewer than two elements', 'next' => 'success'],
                ['label' => '3 from the other sample, or 10 itself', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. A singleton has no successive pair, so 0. Do not reuse 3.\nStep back to when you scored [10].",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. n < 2 → 0. Bucket width (mx-mi)//(n-1). Max successive gap is curmin minus the previous nonempty max. Not O(n log n) sort, not Missing Ranges, not Find Peak. [3,6,9,1] → 3.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
