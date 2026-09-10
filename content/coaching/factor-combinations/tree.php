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
            'message' => "Problem: all factor combinations of n, each factor in [2, n−1]. 12 → [[2,6],[3,4],[2,2,3]]. 1 and 37 → []. The trivial [n] is not allowed.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Combination Sum (39): add candidates to a target; or emit only the prime factorization', 'next' => 'sum'],
                ['label' => 'dfs(remain, start) from 2; if the path is non-empty, record path plus remain; try j from start while j×j ≤ remain', 'next' => 'dfs'],
            ],
        ],
        'sum' => [
            'message' => "39 adds to a sum. Here you multiply factors to n. Prime-only misses 2×6 for 12. Factors must be strictly smaller than n.\nHow do you avoid duplicates and [n]?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Start empty so the first record never fires ([n] stays out). Recurse dfs(remain/j, j) so lists are non-decreasing', 'next' => 'dfs'],
                ['label' => 'Loop j up to remain so [n] and reversed pairs like [6,2] also appear', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong here.\nLooping j to remain reintroduces [n] and reversed duplicates. Stop at sqrt(remain) and keep start ≤ j.\nStep back to when you looped to remain.",
            'outcome' => 'wrong',
            'rewind_to' => 'sum',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "When remain is divisible by j, push j, recurse, pop. 1 is never a factor. Primes have no split in [2, n−1].\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '12 → [2,6], [2,2,3], [3,4]; not [12], not [4,3]', 'next' => 'cpx'],
                ['label' => 'Treat 1 as a factor so 12 also includes [1,12]', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. Factors start at 2. 1 would infinite-loop and is excluded by the range.\nStep back to when you allowed 1.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Search over factor trees; path depth O(log n). Not Combination Sum, not primes-only, not [n], not 1 as a factor.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DFS from 2, non-decreasing, record leftover only when the path is non-empty', 'next' => 'success'],
                ['label' => 'H-Index: sort n’s factors descending and return h', 'next' => 'wrong_h'],
            ],
        ],
        'wrong_h' => [
            'message' => "You are wrong. H-Index counts citations, not factor lists.\nStep back to when you swapped problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs(n, 2) with an empty path. Record t plus remain only when t is non-empty. Try j from start while j×j ≤ remain. Recurse with start j so lists stay sorted. Do not emit [n], 1, or only primes.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
