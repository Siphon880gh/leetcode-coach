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
            'message' => "Problem: n-bit Gray sequence of 2^n integers in [0, 2^n-1], start at 0, each value once, adjacent (and first/last) differ by exactly one bit. n = 2 → [0,1,3,2]. 1 ≤ n ≤ 16.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'List 0..2^n-1 in order, or permute like Permutations', 'next' => 'order'],
                ['label' => 'Map each i in [0, 2^n) to i XOR (i >> 1)', 'next' => 'formula'],
            ],
        ],
        'order' => [
            'message' => "0,1,2,3 is 00,01,10,11 — 1 to 2 flips two bits. Permutations generates all orders, not the Hamming-distance-1 cycle. Binary-reflected Gray code is i XOR (i shifted right by 1).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Subsets DFS: skip or take each bit as a subset, like Subsets', 'next' => 'wrong_sub'],
                ['label' => 'ans[i] = i ^ (i >> 1) for i from 0 to (1 << n) - 1', 'next' => 'formula'],
            ],
        ],
        'wrong_sub' => [
            'message' => "You are wrong here.\nSubsets records collections of numbers. Gray code is a path through all n-bit integers with one-bit steps.\nStep back to when you reused Subsets.",
            'outcome' => 'wrong',
            'rewind_to' => 'order',
            'choices' => [],
        ],
        'formula' => [
            'message' => "Why XOR with i >> 1 (not reverse the bits of i)?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Each Gray bit is binary[i] XOR binary[i+1]; that is exactly x XOR (x >> 1)', 'next' => 'ret'],
                ['label' => 'Reverse bits of i, like a bit-reversal permutation', 'next' => 'wrong_rev'],
            ],
        ],
        'wrong_rev' => [
            'message' => "You are wrong. Bit reversal is a different permutation. Gray keeps the high bit and XORs neighbors.\nStep back to when you reversed bits.",
            'outcome' => 'wrong',
            'rewind_to' => 'formula',
            'choices' => [],
        ],
        'ret' => [
            'message' => "n = 1 → [0,1]. Time O(2^n). Any valid sequence is accepted; this formula is one of them.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The list of Gray codes — not a single integer, not Unique Paths count', 'next' => 'success'],
                ['label' => 'The Hamming distance between 0 and 2^n-1, a single count', 'next' => 'wrong_ham'],
            ],
        ],
        'wrong_ham' => [
            'message' => "You are wrong. Hamming Distance counts differing bits of two numbers. Here you return the whole sequence.\nStep back to when you returned a count.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. For i in 0 .. (1<<n)-1, append i ^ (i >> 1). O(2^n). Adjacent Gray codes differ by one bit. Not 0..2^n-1 in order, not Permutations, not Subsets.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
