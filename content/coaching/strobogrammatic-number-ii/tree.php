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
            'message' => "Problem: all strobogrammatic numbers of length n (any order). n = 2 → [\"11\",\"69\",\"88\",\"96\"]. n = 1 → [\"0\",\"1\",\"8\"]. 1 ≤ n ≤ 14.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '246: test one string with two pointers; or Palindrome Permutation II wrap the same letter both sides', 'next' => 'check'],
                ['label' => 'dfs(u): cores of length u−2, wrap rotate pairs; zeros only when u is not the outer n', 'next' => 'dfs'],
            ],
        ],
        'check' => [
            'message' => "246 checks one candidate. Palindrome Permutation II wraps c + t + c with the same letter. Here the pair can be 6 and 9. 248 counts a numeric range.\nHow do you grow length?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'u=0 → [\"\"]; u=1 → [\"0\",\"1\",\"8\"]; else wrap 11, 88, 69, 96; wrap 00 only if u ≠ n', 'next' => 'dfs'],
                ['label' => 'Always wrap 00 as well, so n = 2 includes \"00\"', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong here.\nLeading zeros are illegal on the finished n-digit string. 00 is not in the n = 2 sample.\nStep back to when you wrapped zeros on the outside.",
            'outcome' => 'wrong',
            'rewind_to' => 'check',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Inner layers may wrap 0 (they sit inside a longer number). Odd n: the middle comes from u = 1, so only 0, 1, 8 — not 6 or 9.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'n = 1 → 0, 1, 8; n = 2 → 11, 69, 88, 96', 'next' => 'cpx'],
                ['label' => 'n = 1 includes \"6\" because 6 is in the rotate map', 'next' => 'wrong_mid'],
            ],
        ],
        'wrong_mid' => [
            'message' => "You are wrong. 6 rotates to 9, not itself. A one-digit number cannot be 6.\nStep back to when you put 6 in the middle.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Output-size exponential in n. Recursion depth O(n). Not a single 246 check, not same-letter palindrome wraps, not 248’s range count.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Recurse n−2 and wrap rotate pairs; no outer 00; middle only 0, 1, 8', 'next' => 'success'],
                ['label' => 'Enumerate every n-digit string and keep those that pass 246', 'next' => 'wrong_enum'],
            ],
        ],
        'wrong_enum' => [
            'message' => "You are wrong. 10ⁿ strings is hopeless at n = 14. Build from shorter cores instead.\nStep back to when you brute-forced every digit string.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs(u) from dfs(u−2). Wrap 11, 88, 69, 96. Wrap 00 only when u is not the finished n. Odd middle is 0, 1, or 8. Not 246, not 266-II.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
