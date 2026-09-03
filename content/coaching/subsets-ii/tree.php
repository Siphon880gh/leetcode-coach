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
            'message' => "Problem: power set of nums that may contain duplicates; unique subsets only. [1,2,2] → [[],[1],[1,2],[1,2,2],[2],[2,2]]. n ≤ 10.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy Subsets: skip/take each index with no extra skip, even though twins exist', 'next' => 'plain'],
                ['label' => 'Sort; dfs take then pop; on the skip branch jump past remaining equals', 'next' => 'dfs'],
            ],
        ],
        'plain' => [
            'message' => "Subsets assumed unique nums. Here two 2s would emit [2] twice if both skip/take trees are independent. Combination Sum II also skips twins, but it targets a sum, not every subset.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Fill unused indices in every order, like Permutations II', 'next' => 'wrong_perm'],
                ['label' => 'After popping nums[i], while the next values equal it, i += 1, then dfs(i+1)', 'next' => 'dfs'],
            ],
        ],
        'wrong_perm' => [
            'message' => "You are wrong here.\nPermutations II lists orderings. A subset is unordered: [1,2] once, not both [1,2] and [2,1].\nStep back to when you used a permutation tree.",
            'outcome' => 'wrong',
            'rewind_to' => 'plain',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Why sort before the twin-skip while-loop?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Equals must sit together so skipping a run drops duplicate skip-trees, not a later distinct 2', 'next' => 'ret'],
                ['label' => 'Sorting is only for output order; skipping unsorted twins still works', 'next' => 'wrong_sort'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong. Without a sort, equal values are not adjacent, so the while-loop cannot skip the twin skip-branch.\nStep back to when you treated sort as cosmetic.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "When i == n, copy t (includes []). Time O(n·2^n). Not Gray Code’s bit sequence, not Combinations’ one k.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The unique power set in any order, including []', 'next' => 'success'],
                ['label' => 'Only subsets that sum to a target, like Combination Sum II', 'next' => 'wrong_sum'],
            ],
        ],
        'wrong_sum' => [
            'message' => "You are wrong. Combination Sum II filters by target. Subsets II lists every distinct subset.\nStep back to when you required a target sum.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort. dfs(i): at n copy t; take nums[i] then pop; skip remaining equals then dfs(i+1). Unique subsets — not Subsets (no twins), not Combination Sum II (no target), not Permutations II. Time O(n·2^n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
