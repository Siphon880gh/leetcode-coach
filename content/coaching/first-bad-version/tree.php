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
            'message' => "Problem: versions 1..n. First bad version; every later version is also bad. Call isBadVersion as few times as possible. n = 5, bad = 4 → 4. n = 1 → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Scan from 1 to n until isBadVersion is true', 'next' => 'scan'],
                ['label' => 'Binary search the first true: if mid is bad, r = mid; else l = mid + 1', 'next' => 'bs'],
            ],
        ],
        'scan' => [
            'message' => "Linear scan is O(n) API calls. n can be 2³¹ − 1. The predicate is monotone false then true, so a lower bound search is enough.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'When mid is bad, set r = mid − 1 (drop mid)', 'next' => 'wrong_drop'],
                ['label' => 'Keep mid when it is bad (r = mid). Leftmost true is the answer', 'next' => 'bs'],
            ],
        ],
        'wrong_drop' => [
            'message' => "You are wrong here.\nIf mid is the first bad, mid − 1 is good. Dropping mid skips the answer.\nStep back to when you set r = mid − 1 on a bad mid.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'bs' => [
            'message' => "l = 1, r = n. While l < r: mid = (l + r) >>> 1 (or l + (r − l) / 2). True → r = mid. False → l = mid + 1. Return l. n = 1 never loops.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'n = 5, bad = 4 → 4. n = 1, bad = 1 → 1', 'next' => 'cpx'],
                ['label' => 'Use signed (l + r) / 2 even when n is 2³¹ − 1', 'next' => 'wrong_ovf'],
            ],
        ],
        'wrong_ovf' => [
            'message' => "You are wrong. l + r can overflow a 32-bit signed int. Use unsigned shift or l + (r − l) / 2.\nStep back to when you added l and r in signed 32-bit.",
            'outcome' => 'wrong',
            'rewind_to' => 'bs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(log n) API calls, O(1) extra. Guess Number is a different API; H-Index II searches a different array.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Lower bound on isBadVersion. Keep a bad mid. Overflow-safe mid. Not a linear scan', 'next' => 'success'],
                ['label' => 'Return r − 1 because the last good version plus one is messy when n = 1', 'next' => 'wrong_last'],
            ],
        ],
        'wrong_last' => [
            'message' => "You are wrong. When the loop ends, l == r is already the first bad. n = 1 returns 1 with no arithmetic on r.\nStep back to when you returned r − 1.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Binary search the first true isBadVersion. If mid is bad, r = mid; else l = mid + 1. Return l. Overflow-safe mid. Not a linear scan, not dropping a bad mid.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
