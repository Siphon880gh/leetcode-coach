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
            'message' => "Problem: exactly k distinct integers from 1 through 9, each at most once, summing to n. k=3, n=7 → [[1,2,4]]. k=3, n=9 → [[1,2,6],[1,3,5],[2,3,4]]. k=4, n=1 → [] (smallest four-sum is 10).\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Combination Sum I: reuse the same digit; any length as long as the sum is n', 'next' => 'reuse'],
                ['label' => 'Take or skip the next digit 1..9; require both remain==0 and length==k', 'next' => 'dfs'],
            ],
        ],
        'reuse' => [
            'message' => "I allows unlimited reuse and any length. II spends an index and skips equal values. Here the pool is 1..9, no reuse, and the length must be k. LCA of a Binary Tree recurses both children — a tree, not digits.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'If both left and right dfs hit, the current node is the LCA', 'next' => 'wrong_lca'],
                ['label' => 'dfs(i, remain): push i then dfs(i+1, remain−i); skip dfs(i+1, remain); prune past 9, over length, or over remain', 'next' => 'dfs'],
            ],
        ],
        'wrong_lca' => [
            'message' => "You are wrong here.\nLCA is a binary-tree walk. This is combinations of digits.\nStep back to when you reused LCA.",
            'outcome' => 'wrong',
            'rewind_to' => 'reuse',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Start at i=1 so paths stay increasing ([1,2,4] not also [2,1,4]). If remain==0, keep a copy only when len==k. Do not recurse dfs(i, …) like I.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '3,7 is [[1,2,4]]; 3,9 is three triples; 4,1 is empty', 'next' => 'cpx'],
                ['label' => 'Any set that sums to n is fine, even if it has 2 or 4 numbers when k is 3', 'next' => 'wrong_len'],
            ],
        ],
        'wrong_len' => [
            'message' => "You are wrong. The combination must have exactly k numbers. A sum of n with the wrong length is illegal.\nStep back to when you dropped the length check.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Search O(2^9) times O(k) to copy a path. Path stack O(k).\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '1..9, no reuse, length k and sum n; not Combination Sum I, not LCA, not any-length sums', 'next' => 'success'],
                ['label' => 'Digits may repeat if they still sum to n, like [1,1,5] for k=3, n=7', 'next' => 'wrong_rep'],
            ],
        ],
        'wrong_rep' => [
            'message' => "You are wrong. Each number is used at most once, and 1 is not two copies.\nStep back to when you allowed repeats.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Digits 1..9, take-or-skip, no reuse. Emit only when remain is 0 and length is k. O(2^9). Not Combination Sum I’s reuse, not II’s duplicate skip on an array, not LCA, not any-length sums.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
