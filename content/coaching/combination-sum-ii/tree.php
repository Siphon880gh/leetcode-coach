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
            'message' => "Problem: candidates may contain duplicates. Each index is used at most once. Return unique combinations that sum to target. [10,1,2,7,6,1,5], target 8 → [1,1,6], [1,2,5], [1,7], [2,6].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy Combination Sum: recurse dfs(j, remaining) so the same index can be reused', 'next' => 'reuse'],
                ['label' => 'Sort; dfs(j+1, remaining); skip c[j]==c[j-1] when j is after the start of this loop', 'next' => 'skip'],
            ],
        ],
        'reuse' => [
            'message' => "This is not unbounded knapsack. Each value at an index may be chosen once. [1,1,6] is legal only because two 1s sit at two indices.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat the two 1s as unlimited supply of 1, so [1,1,1,…] is also fine', 'next' => 'wrong_unlimited'],
                ['label' => 'Recurse dfs(j+1); after sorting, skip later equals at this depth so [1,7] is listed once', 'next' => 'skip'],
            ],
        ],
        'wrong_unlimited' => [
            'message' => "You are wrong here.\nUnlimited reuse is Combination Sum (39). Here each index is consumed, and duplicate values need a skip, not extra copies.\nStep back to when you chose reuse.",
            'outcome' => 'wrong',
            'rewind_to' => 'reuse',
            'choices' => [],
        ],
        'skip' => [
            'message' => "After sort, if j > i and candidates[j] == candidates[j-1], you continue. Why not drop every duplicate from the array first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,1,6] needs both 1s. Skip only sibling branches at this depth, not the second 1 on a deeper call', 'next' => 'example'],
                ['label' => 'Dedup the array to unique values; [1,1,6] then becomes impossible', 'next' => 'wrong_dedup'],
            ],
        ],
        'wrong_dedup' => [
            'message' => "You are wrong. Deduping would forbid using two equal values that came from two indices. The skip is same-level only (j > i).\nStep back to when you chose the skip.",
            'outcome' => 'wrong',
            'rewind_to' => 'skip',
            'choices' => [],
        ],
        'example' => [
            'message' => "dfs(i, s): record when s==0; prune if i is past the end or s < candidates[i]; loop j from i, skip twins, push, dfs(j+1, s-c[j]), pop.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(2^n · n) time before prune; O(n) recursion and path copy', 'next' => 'success'],
                ['label' => 'O(n log n) because sorting is the whole algorithm after the skip', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. Sorting enables prune and the twin skip. The work is still a binary-style include/skip tree over n indices.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort. Each index at most once via dfs(j+1). Skip c[j]==c[j-1] when j>i so combinations stay unique. Prune when remaining is below candidates[i]. Time exponential; stack O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
