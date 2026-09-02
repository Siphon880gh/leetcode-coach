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
            'message' => "Problem: nums may contain duplicates. Return unique permutations. [1,1,2] → [[1,1,2],[1,2,1],[2,1,1]]. n ≤ 8.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy Permutations: vis[j] only, no sort and no equal-neighbor skip', 'next' => 'copy46'],
                ['label' => 'Sort, then dfs with vis; skip j if nums[j]==nums[j-1] and vis[j-1] is false', 'next' => 'skip'],
            ],
        ],
        'copy46' => [
            'message' => "The two 1s sit at different indices, so vis alone emits [1,1,2] twice (swap which 1 is first).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Dedup the array to [1,2] first, then permute', 'next' => 'wrong_dedup'],
                ['label' => 'After sorting, do not pick a value whose previous identical index is still unused', 'next' => 'skip'],
            ],
        ],
        'wrong_dedup' => [
            'message' => "You are wrong here.\n[1,1,2] is a required answer. Deduping would only produce permutations of [1,2].\nStep back to when you dropped a 1.",
            'outcome' => 'wrong',
            'rewind_to' => 'copy46',
            'choices' => [],
        ],
        'skip' => [
            'message' => "The skip is: j>0 and nums[j]==nums[j-1] and not vis[j-1]. Why require the previous twin to already be used?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Identical values must be chosen in index order, so the same multiset is not generated twice', 'next' => 'example'],
                ['label' => 'That skip is Combination Sum II (loop from i); here you should skip vis[j-1] being true', 'next' => 'wrong_flip'],
            ],
        ],
        'wrong_flip' => [
            'message' => "You are wrong. If vis[j-1] is already true, this path is using the earlier twin and the later twin is a new slot — that is legal. Skipping when the earlier twin is unused is what kills the duplicate branch.\nStep back to when you read the skip.",
            'outcome' => 'wrong',
            'rewind_to' => 'skip',
            'choices' => [],
        ],
        'example' => [
            'message' => "Same dfs(i) as Permutations: fill slot i, copy t at i==n. Sort first so equals are adjacent. [1,1,2] yields three unique lists.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n · n!) time to emit unique permutations; O(n) extra for vis and t', 'next' => 'success'],
                ['label' => 'O(n log n) because sorting removes the need for a search tree', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. Sorting only groups twins. You still walk a permutation tree and copy each unique path.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort. dfs(i) with vis. Skip when nums[j]==nums[j-1] and vis[j-1] is false so equal values are used in index order. Copy t at depth n. Time O(n · n!). Not 46 without a skip, and not Combination Sum II.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
