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
            'message' => "Problem: all k-combinations from [1, n]. n=4, k=2 → [[1,2],[1,3],[1,4],[2,3],[2,4],[3,4]]. [1,2] and [2,1] are the same. n ≤ 20.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DFS with a used[] mask and every order, like Permutations', 'next' => 'perm'],
                ['label' => 'dfs(i): take i then dfs(i+1), or skip i then dfs(i+1); record when len(t)==k', 'next' => 'choose'],
            ],
        ],
        'perm' => [
            'message' => "Order does not matter here. A used[] permutation tree emits both [1,2] and [2,1]. Combinations pick a set, so the next index only moves forward.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reuse the same i like Combination Sum (candidates that hit a target)', 'next' => 'wrong_sum'],
                ['label' => 'Start at 1; at each i, append then recurse i+1, pop, then recurse i+1 without it', 'next' => 'choose'],
            ],
        ],
        'wrong_sum' => [
            'message' => "You are wrong here.\nCombination Sum loops a candidate list and may reuse j to hit a target. This problem has no target — only k distinct picks from 1..n.\nStep back to when you reused Combination Sum.",
            'outcome' => 'wrong',
            'rewind_to' => 'perm',
            'choices' => [],
        ],
        'choose' => [
            'message' => "If len(t)==k, append a copy of t. If i>n, return. Why t[:] (or a new list) instead of ans.append(t)?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 't is mutated on the way back; without a copy every answer aliases the same list', 'next' => 'complex'],
                ['label' => 'Skip twins at this depth, like Combination Sum II', 'next' => 'wrong_twins'],
            ],
        ],
        'wrong_twins' => [
            'message' => "You are wrong. Numbers 1..n are already unique. Combination Sum II skips duplicate values in a sorted candidate array; that is a different problem.\nStep back to when you added a twin skip.",
            'outcome' => 'wrong',
            'rewind_to' => 'choose',
            'choices' => [],
        ],
        'complex' => [
            'message' => "You may instead loop j from i to n, push j, dfs(j+1), pop — still no reuse. Time O(C(n,k)·k), stack O(k).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The list of k-length combinations (any order among them), dfs(1) from the main call', 'next' => 'success'],
                ['label' => 'Only the count C(n,k), like N-Queens II', 'next' => 'wrong_count'],
            ],
        ],
        'wrong_count' => [
            'message' => "You are wrong. This signature returns the combinations themselves. N-Queens II returns a count.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'complex',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs(i) from 1: take i then dfs(i+1), or skip and dfs(i+1). Record a copy when the path has k numbers. Combinations, not permutations, not Combination Sum reuse, not Combination Sum II twin-skips. Time O(C(n,k)·k).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
