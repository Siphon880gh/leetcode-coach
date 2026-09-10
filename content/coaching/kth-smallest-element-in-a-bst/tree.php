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
            'message' => "Problem: BST root and 1-indexed k. Return the k-th smallest value. 1 ≤ k ≤ n ≤ 10⁴. [3,1,4,null,2], k=1 → 1. [5,3,6,2,4,null,null,1], k=3 → 3.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Dump inorder into a list then pick index k, or a heap like Kth Largest in an Array (215)', 'next' => 'wrongish'],
                ['label' => 'Inorder walk: left spine, visit and decrement k, return when k hits 0, then go right', 'next' => 'inorder'],
            ],
        ],
        'wrongish' => [
            'message' => "A full list is correct but does extra work when k is small. 215 heaps an unordered array; here BST inorder is already sorted.\nHow do you stop early?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Iterative stack (or a shared counter): push left, pop, k minus 1, if k==0 return val, else go right', 'next' => 'inorder'],
                ['label' => 'Treat k as 0-indexed so k=1 returns the second-smallest', 'next' => 'wrong_idx'],
            ],
        ],
        'wrong_idx' => [
            'message' => "You are wrong here.\nk is 1-indexed. k=1 is the minimum, not the second value.\nStep back to when you used a 0-based k.",
            'outcome' => 'wrong',
            'rewind_to' => 'wrongish',
            'choices' => [],
        ],
        'inorder' => [
            'message' => "Follow-up with frequent queries plus inserts: store subtree sizes and branch by left-count versus k. This one-shot problem only needs the inorder halt.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[3,1,4,null,2], k=1 → 1; [5,3,6,2,4,null,null,1], k=3 → 3', 'next' => 'cpx'],
                ['label' => 'Walk the right spine first so you get the k-th largest', 'next' => 'wrong_side'],
            ],
        ],
        'wrong_side' => [
            'message' => "You are wrong. Right-first is k-th largest. Smallest means left, visit, right.\nStep back to when you swapped the sides.",
            'outcome' => 'wrong',
            'rewind_to' => 'inorder',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(h+k) typical, O(n) worst. O(h) stack. Not a full n-list, not 215, not 0-based k.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Inorder halt at k==0; not a full dump, not a heap, not 0-index, not right-first', 'next' => 'success'],
                ['label' => 'Binary-search the value range without using BST left/right order', 'next' => 'wrong_bs'],
            ],
        ],
        'wrong_bs' => [
            'message' => "You are wrong. The tree’s left/right order is the sort. Searching numeric range without walking inorder ignores the BST.\nStep back to when you searched values instead of inorder rank.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Inorder, decrement k, return when k hits 0. 1-indexed. O(h+k). Not a full list, not 215, not 0-based k, not the right spine.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
