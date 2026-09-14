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
            'message' => "Problem: lowercase s, length 1 to 1e5. Return the index of the first character that appears exactly once. If every letter repeats, return −1. leetcode → 0 (l). loveleetcode → 2 (v). aabb → −1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'From every i, scan the rest of s to test uniqueness', 'next' => 'wrong_nest'],
                ['label' => 'Count all letters, then walk left to right for the first count of 1', 'next' => 'cnt'],
            ],
        ],
        'wrong_nest' => [
            'message' => "You are wrong here. A nested scan is quadratic. At 1e5 that is too slow.\nStep back to when you scanned from every index.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'cnt' => [
            'message' => "Counter(s) or 26 slots. Then for i, c in enumerate(s): if cnt[c] is 1, return i. If the walk finishes, return −1. A queue of candidate indices (drop when a letter hits 2) is the same linear idea.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the character instead of its index, or pick the last unique index', 'next' => 'wrong_ret'],
                ['label' => 'Return the first index with count 1; aabb is −1', 'next' => 'kind'],
            ],
        ],
        'wrong_ret' => [
            'message' => "You are wrong. The API wants an index, not l or v. Last unique would be wrong on loveleetcode (e is not first).\nStep back to when you returned a letter or the last unique.",
            'outcome' => 'wrong',
            'rewind_to' => 'cnt',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Single Number (136) is XOR on ints. First Unique Number (1429) is a stream with add / showFirstUnique — same count idea, different API.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count then first index of 1. leetcode → 0. Not 136', 'next' => 'success'],
                ['label' => 'XOR the letters, or treat this as the 1429 stream API', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. XOR does not give the first unique letter in a string. 1429 has add and showFirstUnique, not a one-shot index.\nStep back to when you used 136 or 1429.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Count, then the first index whose count is 1. leetcode → 0. loveleetcode → 2. aabb → −1. Not a nested scan.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
