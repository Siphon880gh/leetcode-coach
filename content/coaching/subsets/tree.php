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
            'message' => "Problem: all subsets of unique nums (the power set). [1,2,3] includes [] and [1,2,3]. n ≤ 10.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only record paths of length k, like Combinations', 'next' => 'konly'],
                ['label' => 'dfs(i): if i==n copy t; else skip dfs(i+1), then take nums[i], dfs(i+1), pop', 'next' => 'dfs'],
            ],
        ],
        'konly' => [
            'message' => "Combinations asked for one k. Here every length is required, including the empty list. You record once per finished scan of the array, not at a fixed size.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Fill unused indices in every order, like Permutations', 'next' => 'wrong_perm'],
                ['label' => 'At index i, first recurse without nums[i], then append, recurse, pop', 'next' => 'dfs'],
            ],
        ],
        'wrong_perm' => [
            'message' => "You are wrong here.\nA subset is a set: [1,2] and [2,1] must not both appear. The index only moves forward.\nStep back to when you used a permutation tree.",
            'outcome' => 'wrong',
            'rewind_to' => 'konly',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Call dfs(0). When i==n, append t[:]. Why copy instead of storing t itself?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 't is shared and popped on the way back; without a copy every answer aliases one list', 'next' => 'empty'],
                ['label' => 'Skip twin values at this depth, like Subsets II, even though nums are unique', 'next' => 'wrong_twins'],
            ],
        ],
        'wrong_twins' => [
            'message' => "You are wrong. This constraint says nums are unique. Subsets II is a later problem that skips duplicates after a sort.\nStep back to when you added a twin skip.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'empty' => [
            'message' => "The skip-first branch produces []. Time O(n·2^n) to copy 2^n subsets; stack O(n).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'All 2^n subsets in any order, including []', 'next' => 'success'],
                ['label' => 'Only nonempty subsets; drop []', 'next' => 'wrong_empty'],
            ],
        ],
        'wrong_empty' => [
            'message' => "You are wrong. Example 1 and 2 both include []. The power set contains the empty set.\nStep back to when you dropped the empty subset.",
            'outcome' => 'wrong',
            'rewind_to' => 'empty',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs(0): at i==n copy t; otherwise skip then take nums[i] (always i+1). Record every length, including []. Unique nums — not Combinations (one k), not Permutations, not Subsets II. Time O(n·2^n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
