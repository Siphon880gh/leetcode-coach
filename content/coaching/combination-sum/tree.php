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
            'message' => "Problem: distinct candidates, unlimited reuse. Return unique combinations that sum to target. [2,3,6,7], target 7 → [[2,2,3],[7]]. Candidates length ≤ 30.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Nested for-loops whose depth is target divided by the smallest candidate', 'next' => 'nested'],
                ['label' => 'Sort, then dfs(i, remaining): take candidates[j] for j from i onward, recurse on the same j', 'next' => 'dfs'],
            ],
        ],
        'nested' => [
            'message' => "You do not know how many addends a combination will have ([2,2,2,2] vs [3,5]). Fixed nesting cannot cover every length.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stop at 150 loops because the problem caps unique combinations below 150', 'next' => 'wrong_cap'],
                ['label' => 'dfs(i, s): if s==0 record the path; for j in [i, n) push c[j], recurse dfs(j, s-c[j]), pop', 'next' => 'dfs'],
            ],
        ],
        'wrong_cap' => [
            'message' => "You are wrong here.\n150 is a test-case bound, not a search strategy. You still need a recursive branch that can grow any length.\nStep back to when you chose how to nest.",
            'outcome' => 'wrong',
            'rewind_to' => 'nested',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "The for-loop starts at i and the recursive call is dfs(j, …), not dfs(j+1, …). Why keep j?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The same number may be chosen unlimited times; j+1 would forbid [2,2,3]', 'next' => 'example'],
                ['label' => 'You must skip j so each candidate is used at most once, like Combination Sum II', 'next' => 'wrong_once'],
            ],
        ],
        'wrong_once' => [
            'message' => "You are wrong. This problem allows reuse. Combination Sum II is a different constraint (each index at most once).\nStep back to when you chose the recurse index.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'example' => [
            'message' => "Sort first. If remaining s is already less than candidates[i], later values are larger, so prune. [2,3,6,7] with 7 yields [2,2,3] and [7]. Starting j at i (not 0) keeps [2,3] and skips the permutation [3,2].\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Exponential in the search tree (about O(2^n · n) before prune); path copy O(n) extra', 'next' => 'success'],
                ['label' => 'O(n) because you scan candidates once after sorting', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. Each remaining sum branches over suffixes of candidates. Sorting helps prune; it does not make the search linear.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort, then dfs(i, s). Record when s==0; prune when s < candidates[i]; loop j from i, recurse dfs(j, s-c[j]) so reuse is allowed, pop after. Time exponential; stack O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
