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
            'message' => "Problem: positive integer num (1 .. 2^31 − 1). True iff some integer k has k × k = num. You must not call a language sqrt. 16 → true (4 × 4). 14 → false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Call sqrt (or floor sqrt like 69) and see if the result squared equals num', 'next' => 'wrong_sqrt'],
                ['label' => 'Binary search the smallest x with x × x ≥ num, then test equality', 'next' => 'bs'],
            ],
        ],
        'wrong_sqrt' => [
            'message' => "You are wrong here. The problem forbids library sqrt. 69 wants the floor of the root (14 → 3); here 14 must be false.\nStep back to when you used sqrt or treated this as 69.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'bs' => [
            'message' => "Search [1, num]. While l < r, mid = (l + r) unsigned-right-shift 1. If the square of mid is already ≥ num, r = mid; else l = mid + 1. Then l is the smallest integer with l × l ≥ num. True iff that square equals num.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Multiply mid × mid in 32-bit ints near 2^31 − 1, so the product wraps', 'next' => 'wrong_ov'],
                ['label' => 'Use a 64-bit product, or compare mid ≥ num / mid (l starts at 1)', 'next' => 'kind'],
            ],
        ],
        'wrong_ov' => [
            'message' => "You are wrong. A wrapped product looks smaller than num, so the search goes the wrong way on large squares.\nStep back to when you used a 32-bit multiply.",
            'outcome' => 'wrong',
            'rewind_to' => 'bs',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Scanning i = 1, 2, … until i × i passes num is too slow at the high end. Newton is interview-OK; the writeup is this lower-bound search.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Lower-bound binary search, overflow-safe square. 16 true, 14 false. Not 69, not library sqrt', 'next' => 'success'],
                ['label' => 'Loop i from 1 until i × i exceeds num on every query', 'next' => 'wrong_scan'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong. num can be about 2^31. Linear trial squares will time out.\nStep back to when you scanned every i.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Smallest x with x × x ≥ num, then exact equality. Overflow-safe. 16 true; 14 false. Not floor sqrt (69).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
