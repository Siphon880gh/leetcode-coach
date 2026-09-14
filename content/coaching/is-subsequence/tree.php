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
            'message' => "Problem: s and t are lowercase. Return true if s is a subsequence of t: keep relative order, deletions allowed. abc / ahbgdc → true. axc / ahbgdc → false. ace is a subsequence of abcde; aec is not. Empty s is true. s up to 100, t up to 1e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Require a contiguous substring, or compute LCS length (1143)', 'next' => 'wrong_sub'],
                ['label' => 'Two pointers: walk t, advance in s only on a match', 'next' => 'tp'],
            ],
        ],
        'wrong_sub' => [
            'message' => "You are wrong here. abc sits in ahbgdc with gaps. 1143 asks for a longest shared subsequence of two strings, not a yes/no for a given s.\nStep back to when you required a block or used 1143.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'tp' => [
            'message' => "Pointer i on s, j on t. Walk t. When s[i] equals t[j], advance i. Always advance j. If i reaches len(s), every letter of s was found in order. The leftmost unused copy in t is always as good as a later one for a single query.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat aec as true for abcde, or reverse s before scanning', 'next' => 'wrong_ord'],
                ['label' => 'Keep order. Empty s is true. axc / ahbgdc is false', 'next' => 'kind'],
            ],
        ],
        'wrong_ord' => [
            'message' => "You are wrong. a then e then c is not in that order in abcde (c comes before e). Reversing s answers a different string.\nStep back to when you broke order or reversed s.",
            'outcome' => 'wrong',
            'rewind_to' => 'tp',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Follow-up: many s against one t. Precompute index lists per letter in t, then binary-search the next index strictly after the last pick (792). Do not restart a full scan of t for every s when k is huge.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Greedy two pointers. abc / ahbgdc → true. Not 1143', 'next' => 'success'],
                ['label' => 'Rescan all of t from 0 for every incoming s, even at huge k', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. The follow-up has k around 1e9 queries. A full scan of t per s is too slow; precompute positions.\nStep back to when you rescanned t from scratch each time.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Walk t; advance s only on a match. i == len(s) is true. abc / ahbgdc → true. Empty s → true. Not a substring. Not 1143.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
