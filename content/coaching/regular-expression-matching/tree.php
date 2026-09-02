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
            'message' => "Problem: does s match p entirely? '.' is any one character; '*' is zero or more of the preceding element.\n\"aa\" vs \"a\" → false (must cover the whole string). \"aa\" vs \"a*\" → true. \"ab\" vs \".*\" → true.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hand s and p to the language regex engine', 'next' => 'as_lib'],
                ['label' => 'Memoized dfs(i, j): does s[i:] match p[j:]?', 'next' => 'dfs'],
            ],
        ],
        'as_lib' => [
            'message' => "Host regex engines differ (partial match, extra syntax). This problem is only '.' and '*' and must cover all of s.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat * as glob-star: match any remaining substring', 'next' => 'wrong_glob'],
                ['label' => 'Recurse on indices in s and p; cache each (i, j)', 'next' => 'dfs'],
            ],
        ],
        'wrong_glob' => [
            'message' => "You are wrong here.\n'*' applies to the preceding token: a* is a run of a's (possibly empty), not \"anything\". \".*\" is the anything case.\nStep back to when you defined *.",
            'outcome' => 'wrong',
            'rewind_to' => 'as_lib',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "If j is past p, succeed only if i is past s. If p[j+1] is '*', you have a choice.\nHow do you handle x*?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Zero copies: dfs(i, j+2). Or if s[i] matches x or ".", consume one and stay: dfs(i+1, j)', 'next' => 'dot'],
                ['label' => '* always eats the rest of s — greedy is mandatory', 'next' => 'wrong_greedy'],
            ],
        ],
        'wrong_greedy' => [
            'message' => "You are wrong. a* may match zero a's. You try skip (j+2) OR consume one and keep the same x*. Greedy-only fails cases that need zero.\nStep back to when you branched on *.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'dot' => [
            'message' => "No '*': s[i] must equal p[j] or p[j] is '.', then dfs(i+1, j+1). '.' is one character, not a sequence.\nMemoizing (i, j) makes this O(m n). What is the answer for \"aa\" vs \"a*\"?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'true — one a, then a* consumes the second a', 'next' => 'success'],
                ['label' => 'false — a* cannot extend past the first character', 'next' => 'wrong_star'],
            ],
        ],
        'wrong_star' => [
            'message' => "You are wrong. After matching the first a, dfs(i+1, j) still has a* so it can take the second a, then skip with j+2 at the end.\nStep back to when you applied a*.",
            'outcome' => 'wrong',
            'rewind_to' => 'dot',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Full match via memoized dfs: x* is skip or consume-one-and-stay; otherwise one-char (including '.'). Time and space O(m n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
