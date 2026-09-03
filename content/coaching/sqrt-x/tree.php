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
            'message' => "Problem: floor of sqrt(x) for x in 0 .. 2^31-1. Must not use pow or ** 0.5. 4 → 2. 8 → 2.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Call the language sqrt or pow(x, 0.5) and cast to int', 'next' => 'as_lib'],
                ['label' => 'Binary search l=0, r=x; mid biased up; if mid > x/mid then r=mid-1 else l=mid', 'next' => 'bs'],
            ],
        ],
        'as_lib' => [
            'message' => "The problem forbids built-in exponent/sqrt. You need the largest integer mid with mid*mid <= x, in log time.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Scan i from 0 until i*i > x and return i-1', 'next' => 'wrong_scan'],
                ['label' => 'Binary search the answer on [0, x]', 'next' => 'bs'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong here.\nA linear scan is O(sqrt(x)). Binary search is O(log x) and is the writeup solution.\nStep back to when you scanned every i.",
            'outcome' => 'wrong',
            'rewind_to' => 'as_lib',
            'choices' => [],
        ],
        'bs' => [
            'message' => "Why compare mid > x / mid instead of mid * mid > x?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'mid * mid overflows a 32-bit int when x is near 2^31-1; divide stays in range', 'next' => 'bias'],
                ['label' => 'They are the same; overflow is not a concern on this problem', 'next' => 'wrong_mul'],
            ],
        ],
        'wrong_mul' => [
            'message' => "You are wrong. For large x, mid*mid wraps in 32-bit. The writeup uses mid > x / mid (integer divide).\nStep back to when you multiplied.",
            'outcome' => 'wrong',
            'rewind_to' => 'bs',
            'choices' => [],
        ],
        'bias' => [
            'message' => "mid = (l + r + 1) >> 1, and the true branch sets l = mid. Why the +1?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Without the bias, l = mid can stall when l+1==r. Floor of 8 is 2, not 3', 'next' => 'success'],
                ['label' => 'Return ceil(sqrt(x)); 8 should be 3', 'next' => 'wrong_ceil'],
            ],
        ],
        'wrong_ceil' => [
            'message' => "You are wrong. The spec rounds down. 8 → 2. After the loop, return l.\nStep back to when you chose ceil.",
            'outcome' => 'wrong',
            'rewind_to' => 'bias',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. l=0, r=x. While l < r, mid = (l+r+1)>>1; if mid > x/mid then r=mid-1 else l=mid. Return l. Time O(log x). Integer floor sqrt — not language sqrt, and not Pow(x, n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
