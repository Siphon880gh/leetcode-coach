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
            'message' => "Problem: nums are distinct. Return every permutation, any order. [1,2,3] → six lists. n ≤ 6.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Next Permutation in a loop until the array returns to the start', 'next' => 'nextp'],
                ['label' => 'DFS position i: try each unused index j, place nums[j], recurse i+1, then unmark', 'next' => 'dfs'],
            ],
        ],
        'nextp' => [
            'message' => "That can list them in lex order, but it is a different algorithm (pivot, swap, reverse suffix). The usual search is a tree of unused picks.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat them as combinations: recurse dfs(j) so order does not matter', 'next' => 'wrong_combo'],
                ['label' => 'vis[j] so each index is used once per path; when i == n, append a copy of t', 'next' => 'dfs'],
            ],
        ],
        'wrong_combo' => [
            'message' => "You are wrong here.\n[1,2,3] and [3,2,1] are different permutations. Combinations collapse order; this problem must keep it.\nStep back to when you chose combinations.",
            'outcome' => 'wrong',
            'rewind_to' => 'nextp',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Why copy t when i reaches n, instead of appending the same list object?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Later backtracking mutates t; without t[:] every answer would share one array', 'next' => 'example'],
                ['label' => 'Skip the copy; n is tiny so sharing t is fine', 'next' => 'wrong_alias'],
            ],
        ],
        'wrong_alias' => [
            'message' => "You are wrong. After dfs returns, vis is cleared and t is overwritten. All stored answers would show the last state.\nStep back to when you recorded a permutation.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'example' => [
            'message' => "dfs(0) tries each unused j for slot 0, then slot 1, and so on. [1,2,3] yields 3! = 6 permutations. Permutations II (duplicates) is a later skip; here nums are unique.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n · n!) time to build n! lists of length n; O(n) extra for vis and t', 'next' => 'success'],
                ['label' => 'O(n²) because you nest two loops over indices', 'next' => 'wrong_n2'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong. The search tree has n! leaves. Copying each path is O(n), so the total is Θ(n · n!).\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs(i): if i==n, append t[:]. Else for each unused j, mark, set t[i], dfs(i+1), unmark. Distinct nums, so vis on indices is enough. Time O(n · n!). Not Next Permutation and not combinations.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
