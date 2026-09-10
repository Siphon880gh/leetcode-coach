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
            'message' => "Problem: BST root, float target, integer k. Return the k closest node values (any order). [4,2,5,1,3], target 3.714286, k = 2 → [4,3]. Single node [1], k = 1 → [1].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '270’s one search path: keep a single closer (or smaller-on-tie) champion', 'next' => 'one'],
                ['label' => 'Inorder is sorted; keep a deque of k consecutive neighbors', 'next' => 'window'],
            ],
        ],
        'one' => [
            'message' => "270 returns one value. Here the k nearest sit together on the inorder line. A search path misses neighbors off the path.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Dump every value, sort by abs(val − target), take k', 'next' => 'wrong_dump'],
                ['label' => 'Walk inorder. Fill a deque of size k. Then slide or prune', 'next' => 'window'],
            ],
        ],
        'wrong_dump' => [
            'message' => "You are wrong here.\nSorting the whole tree by distance works but skips the prune: later inorder values only get farther.\nStep back to when you dumped the full list.",
            'outcome' => 'wrong',
            'rewind_to' => 'one',
            'choices' => [],
        ],
        'window' => [
            'message' => "If q has fewer than k values, append. Else if abs(val − target) >= abs(q[0] − target), return (skip the right tail). Else popleft and append.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[4,2,5,1,3], k = 2, target ≈ 3.71 → [4,3] (or [3,4])', 'next' => 'cpx'],
                ['label' => 'Stop after the first closest node; ignore k', 'next' => 'wrong_stop'],
            ],
        ],
        'wrong_stop' => [
            'message' => "You are wrong. That is 270. k = 2 needs both 3 and 4.\nStep back to when you stopped at one champion.",
            'outcome' => 'wrong',
            'rewind_to' => 'window',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) worst, O(k) extra for the deque, plus height. A size-k heap without sorted inorder loses the early return.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Inorder window of k; prune when the next is no closer than q[0]. Not 270, not a full distance sort', 'next' => 'success'],
                ['label' => 'Keep a max-heap of k random-order nodes; never use inorder', 'next' => 'wrong_heap'],
            ],
        ],
        'wrong_heap' => [
            'message' => "You are wrong on this path. A heap can be correct but you lose the prune that later inorder is farther. The teaching solution is the deque window.\nStep back to when you skipped inorder.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Inorder window of k consecutive values. When the next is no closer than the left of the deque, prune the rest. Not 270’s single closest, not a full distance sort.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
