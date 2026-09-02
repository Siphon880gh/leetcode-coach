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
            'message' => "Problem: s = \"abcabcbb\". Find the length of the longest substring without repeating characters.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Enumerate every substring and test uniqueness', 'next' => 'brute'],
                ['label' => 'Grow a window to the right; shrink the left when a duplicate appears', 'next' => 'window_idea'],
            ],
        ],
        'brute' => [
            'message' => "Checking every substring works, but n can be 10⁵ so O(n²) or worse is too slow.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Restart a fresh scan from every index i', 'next' => 'wrong_restart'],
                ['label' => 'Keep a unique window [l, r]: move r, then move l until it is unique again', 'next' => 'window_idea'],
            ],
        ],
        'wrong_restart' => [
            'message' => "You are wrong here.\nRestarting from every i is still quadratic. The left pointer only moves forward, so each index is processed a constant number of times.\nStep back to when you chose how to avoid O(n²).",
            'outcome' => 'wrong',
            'rewind_to' => 'brute',
            'choices' => [],
        ],
        'window_idea' => [
            'message' => "s = \"pwwkew\". Why is \"pwke\" not the answer?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'It is a subsequence, not a contiguous substring', 'next' => 'expand'],
                ['label' => 'It is the longest unique string, so return 4', 'next' => 'wrong_subseq'],
            ],
        ],
        'wrong_subseq' => [
            'message' => "You are wrong. The answer must be a substring. \"wke\" (and \"kew\") has length 3; \"pwke\" skips the middle w.\nStep back to when you distinguished substring from subsequence.",
            'outcome' => 'wrong',
            'rewind_to' => 'window_idea',
            'choices' => [],
        ],
        'expand' => [
            'message' => "Walk r through \"abcabcbb\". After \"abc\", r lands on a duplicate a. Counts in the window: a appears twice.\nWhat do you do?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Advance l until cnt[a] is 1, then record r − l + 1', 'next' => 'shrink'],
                ['label' => 'Clear the window and start over from the new r', 'next' => 'wrong_reset'],
            ],
        ],
        'wrong_reset' => [
            'message' => "You are wrong. Sliding means l only moves forward — you keep the unique suffix (\"bc\") instead of throwing the window away.\nStep back to when the duplicate appeared.",
            'outcome' => 'wrong',
            'rewind_to' => 'expand',
            'choices' => [],
        ],
        'shrink' => [
            'message' => "Invariant: every character in [l, r] appears once. After each shrink, ans = max(ans, r − l + 1).\nFor s = \"bbbbb\", what is ans?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '1 — a single character is a valid substring', 'next' => 'success'],
                ['label' => '0 — every character repeats', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. Repeats force the window down to length 1, not 0. A single character has no duplicate.\nStep back to when you scored \"bbbbb\".",
            'outcome' => 'wrong',
            'rewind_to' => 'shrink',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sliding window + a count (hash or 128-slot array): expand r, while cnt[c] > 1 shrink l. Time O(n), space O(|Σ|).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
