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
            'message' => "Problem: n up to about 5e4. Return every integer in [1, n] in lexicographical order. n=13 → [1, 10, 11, 12, 13, 2, 3, 4, 5, 6, 7, 8, 9]. Must be O(n) time and O(1) extra space besides the answer.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stringify 1..n and sort, or write 1,2,3 then insert tens by hand', 'next' => 'wrong_sort'],
                ['label' => 'Walk a 10-ary digit trie: start at 1, go deeper when 10×v is still ≤ n', 'next' => 'dfs'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong here. Sorting strings is extra log time and extra string memory; the follow-up forbids it. Hand-inserting tens is not an algorithm.\nStep back to when you sorted strings or patched a numeric list.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "v starts at 1. Repeat n times: append v. If 10×v ≤ n, set v to 10×v (append a 0). Else while v ends in 9 or v+1 would exceed n, integer-divide v by 10 (pop a digit), then add 1 (next sibling).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip the ends-in-9 / past-n climb, or start at 0', 'next' => 'wrong_climb'],
                ['label' => 'Climb when you cannot extend; roots are 1..9, never 0', 'next' => 'kind'],
            ],
        ],
        'wrong_climb' => [
            'message' => "You are wrong. Without the climb you stall at 19 when n is 25. Starting at 0 emits a prefix that is not in [1, n].\nStep back to when you skipped the climb or started at 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'kind' => [
            'message' => "K-th Smallest in Lexicographical Order (440) counts how many numbers share a prefix. Here you emit every number. Recursive twin: from prefix v try digits 0..9 as 10×v+d when that value is at most n.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Emit all n values in preorder. n=13 starts 1,10,11. Not 440', 'next' => 'success'],
                ['label' => 'Only count prefixes like 440, or return numeric order 1,2,3 for n=13', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. 440 asks for the k-th number, not the full list. Numeric order for n=13 is not lexicographical (10 comes after 1, before 2).\nStep back to when you reused 440 or emitted 1,2,3.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Ten-ary DFS: deepen with 10×v, else climb and add 1. n=13 → [1,10,11,12,13,2,…,9]. Not stringify-sort. Not 440.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
