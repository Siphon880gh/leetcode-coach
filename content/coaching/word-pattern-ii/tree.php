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
            'message' => "Problem: s has no spaces. True iff letters bijection-map to non-empty substrings that concatenate to s. abab / redblueredblue → true. aaaa / asdasdasdasd → true. aabb / xyzabcxzyabc → false. Lengths up to 20.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Split s on spaces like Word Pattern (290)', 'next' => 'wrong_split'],
                ['label' => 'DFS: invent every non-empty cut, bind or reuse, then backtrack', 'next' => 'dfs'],
            ],
        ],
        'wrong_split' => [
            'message' => "You are wrong here.\nThere are no spaces. Word Pattern already split; here you invent the cuts.\nStep back to when you reused the space split.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "dfs(i, j): both at the end → true. One leftover, or remaining chars fewer than remaining letters → false. For each end k, t = s[j .. k]. If the letter is already mapped to t, recurse. If unbound and t unused, bind, recurse, unbind.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip the used-string set; two letters may share the same t', 'next' => 'wrong_share'],
                ['label' => 'Exponential in n (n ≤ 20). First success returns true', 'next' => 'cpx'],
            ],
        ],
        'wrong_share' => [
            'message' => "You are wrong. Bijection: no two letters map to the same substring. Keep a used set and unbind on the way back.\nStep back to when you skipped vis.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "aaaa / asdasdasdasd needs a → asd (length 3), not the first character only. Word Break has a dictionary; here you invent the words.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Try every cut, backtrack binds. Not space-split, not a shared t', 'next' => 'success'],
                ['label' => 'Take the first letter’s first cut only; never try a longer t', 'next' => 'wrong_first'],
            ],
        ],
        'wrong_first' => [
            'message' => "You are wrong. The first cut may be too short. Backtrack and try longer substrings.\nStep back to when you froze the first cut.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Invent cuts with DFS. Bind unused substrings, reuse a bound word, unbind on failure. Not Word Pattern’s space split. n ≤ 20.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
