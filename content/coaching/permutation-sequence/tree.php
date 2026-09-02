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
            'message' => "Problem: k-th lexicographic permutation of 1..n as a string (k is 1-based). n=3, k=3 → \"213\". n=4, k=9 → \"2314\". n ≤ 9.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Generate every permutation like Permutations I, then return index k-1', 'next' => 'all'],
                ['label' => 'For each slot, fact = (n-i-1)!; skip unused digits while k > fact, then take that digit', 'next' => 'fact'],
            ],
        ],
        'all' => [
            'message' => "Listing n! strings is Permutations I. Here you only need one sequence; the writeup is O(n²).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Start from "123..n" and call next_permutation exactly k-1 times', 'next' => 'wrong_next'],
                ['label' => 'Each unused digit heads a block of fact perms; subtract fact until k fits, then mark vis', 'next' => 'fact'],
            ],
        ],
        'wrong_next' => [
            'message' => "You are wrong here.\nRepeated next_permutation works but walks k steps. The taught method picks each digit from factorial block sizes in O(n²).\nStep back to when you walked k permutations.",
            'outcome' => 'wrong',
            'rewind_to' => 'all',
            'choices' => [],
        ],
        'fact' => [
            'message' => "k stays 1-based: if k > fact, subtract and try the next unused digit. Why not always pick the smallest unused?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The smallest unused is only correct when k is still inside that digit’s first fact block', 'next' => 'example'],
                ['label' => 'Always append the smallest unused; k only chooses how many swaps to do later', 'next' => 'wrong_small'],
            ],
        ],
        'wrong_small' => [
            'message' => "You are wrong. Always taking 1 first would make every answer start with 1. For n=3, k=3 the first digit is 2.\nStep back to when you ignored the block size.",
            'outcome' => 'wrong',
            'rewind_to' => 'fact',
            'choices' => [],
        ],
        'example' => [
            'message' => "n=3, k=3: first slot fact=2; skip 1 (k becomes 1), take 2. Then remaining 1,3 with fact=1 yield \"213\". vis prevents reuse.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n²) time, O(n) extra for vis and the answer', 'next' => 'success'],
                ['label' => 'O(n!) because you still generate every permutation internally', 'next' => 'wrong_nfact'],
            ],
        ],
        'wrong_nfact' => [
            'message' => "You are wrong. Each of n positions scans at most n unused digits. No n! list is built.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. For each position, fact = (remaining-1)!. Walk unused 1..n; if k > fact, k -= fact; else append, mark vis, break. Time O(n²). The k-th string — not Permutations I’s full list, and not k-1 next_permutation calls.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
