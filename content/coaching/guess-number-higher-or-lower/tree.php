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
            'message' => "Problem: pick is hidden in 1..n (n up to 2^31 − 1). Call guess(num): −1 if num is too high, 1 if too low, 0 if exact. Return the pick. n=10, pick=6 → 6. n=1, pick=1 → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Scan 1, 2, … n with guess, or treat this as First Bad Version (278)', 'next' => 'wrong_scan'],
                ['label' => 'Binary search: first x with guess(x) ≤ 0', 'next' => 'bs'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong here. n can be about 2 billion API calls. 278 uses a boolean isBadVersion on versions, not −1 / 1 / 0.\nStep back to when you scanned or treated this as 278.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'bs' => [
            'message' => "guess(x) is positive while x is below the pick, then non-positive from the pick on. l=1, r=n. While l < r: mid = (l + r) unsigned-right-shift 1 (or l + ((r − l) >> 1)). If guess(mid) ≤ 0, r = mid; else l = mid + 1. Then l is the pick.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'On guess(mid) ≤ 0 set r = mid − 1, or use signed (l + r) / 2 at n = 2^31 − 1', 'next' => 'wrong_bound'],
                ['label' => 'Keep the pick in [l, mid] when guess(mid) ≤ 0; overflow-safe mid', 'next' => 'kind'],
            ],
        ],
        'wrong_bound' => [
            'message' => "You are wrong. Dropping mid when guess(mid) is 0 or −1 can skip the pick. Signed (l + r) / 2 overflows at the high end of n.\nStep back to when you moved r past mid or used a wrapping midpoint.",
            'outcome' => 'wrong',
            'rewind_to' => 'bs',
            'choices' => [],
        ],
        'kind' => [
            'message' => "−1 means your guess was too high (num > pick), not the other way. Guess Number II (375) is minmax DP on worst-case cost, not this API hunt.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Lower-bound binary search on guess ≤ 0. Not 278. Not 375', 'next' => 'success'],
                ['label' => 'Flip the API signs, or solve 375 minmax for a money cost', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. Flipped signs send the search the wrong way. 375 is a different problem.\nStep back to when you flipped guess or jumped to 375.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. First x with guess(x) ≤ 0, overflow-safe mid. n=10, pick=6 → 6. Not 278. Not 375.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
