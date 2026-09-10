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
            'message' => "Problem: nums has length n+1, values in 1..n, exactly one value repeats (two or more times). Return it. Do not mutate nums. O(1) extra. [1,3,4,2,2] → 2.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hash set of seen values (O(n) extra)', 'next' => 'wrong_set'],
                ['label' => 'Pigeonhole binary search, or Floyd on nums[i] as next', 'next' => 'ok'],
            ],
        ],
        'wrong_set' => [
            'message' => "You are wrong here.\nThe spec asks constant extra space. A set is Contains Duplicate, not this problem.\nStep back to when you allocated a set.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'ok' => [
            'message' => "Binary search x in 1..n: count how many v ≤ x. If count > x, the duplicate is in 1..x; else in x+1..n. Floyd: slow/fast on i → nums[i], then one pointer from 0 and one from the meet; they meet at the duplicate.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'XOR 1..n with the array (fails when the duplicate appears three or more times)', 'next' => 'wrong_xor'],
                ['label' => 'O(n log n) pigeonhole or O(n) Floyd. Do not sort in place', 'next' => 'cpx'],
            ],
        ],
        'wrong_xor' => [
            'message' => "You are wrong. [3,3,3,3,3] is a valid input. XOR with 1..n does not isolate a value that appears more than twice.\nStep back to when you used XOR.",
            'outcome' => 'wrong',
            'rewind_to' => 'ok',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(1) extra. Pigeonhole proves a duplicate exists (n+1 pigeons, n holes).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count ≤ mid, or Floyd entrance. Not a set, not mutate, not XOR for 3+ copies', 'next' => 'success'],
                ['label' => 'First Missing Positive: seat values in place (mutates nums)', 'next' => 'wrong_41'],
            ],
        ],
        'wrong_41' => [
            'message' => "You are wrong. First Missing Positive swaps into index slots. This problem forbids mutating nums.\nStep back to when you swapped in place.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Pigeonhole: if more than x values are ≤ x, search 1..x. Floyd: cycle entrance on nums[i] as next. No set, no mutate. [3,3,3,3,3] → 3.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
