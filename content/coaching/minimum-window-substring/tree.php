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
            'message' => "Problem: shortest substring of s that covers every character of t, including duplicates. s = \"ADOBECODEBANC\", t = \"ABC\" → \"BANC\". s = \"a\", t = \"aa\" → \"\". Lengths up to 1e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Grow a unique-character window like Longest Substring Without Repeating Characters', 'next' => 'unique'],
                ['label' => 'Count need from t; expand r; when cnt == len(t), record length and shrink l', 'next' => 'cover'],
            ],
        ],
        'unique' => [
            'message' => "That problem maximizes a window with no repeats. Here t may repeat letters, and extra copies of unused letters are allowed. You need a covering window, then the shortest one.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hop by word length like Substring with Concatenation of All Words', 'next' => 'wrong_words'],
                ['label' => 'need/window counts plus cnt of satisfied t-occurrences; shrink while the window still covers t', 'next' => 'cover'],
            ],
        ],
        'wrong_words' => [
            'message' => "You are wrong here.\nConcatenation of All Words slides in fixed-size word steps. Here characters can appear anywhere in the window.\nStep back to when you reused the word-window.",
            'outcome' => 'wrong',
            'rewind_to' => 'unique',
            'choices' => [],
        ],
        'cover' => [
            'message' => "After adding s[r], if need[c] >= window[c], that copy was still required, so cnt++. While cnt == len(t), why shrink l instead of stopping?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The first covering window may be long; keep dropping s[l] and track the min (r-l+1, k=l)', 'next' => 'empty'],
                ['label' => 'The first time cnt == len(t) is the answer; \"ADOBEC\" would be fine', 'next' => 'wrong_first'],
            ],
        ],
        'wrong_first' => [
            'message' => "You are wrong. Example 1 wants \"BANC\", not the earlier \"ADOBEC\". You must keep shrinking and scanning for a shorter cover.\nStep back to when you returned the first cover.",
            'outcome' => 'wrong',
            'rewind_to' => 'cover',
            'choices' => [],
        ],
        'empty' => [
            'message' => "When shrinking, if need[s[l]] >= window[s[l]] before the decrement, cnt--. If k stays -1, no cover exists (\"a\" vs \"aa\").\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 's[k:k+mi] if k >= 0, else "" — a substring, O(m+n) time', 'next' => 'success'],
                ['label' => 'A subsequence that picks t’s letters out of order, not a contiguous slice', 'next' => 'wrong_subseq'],
            ],
        ],
        'wrong_subseq' => [
            'message' => "You are wrong. The answer is a substring of s. Jumping letters is a subsequence.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'empty',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Count t in need. Expand r; cnt counts satisfied copies (duplicates matter). While the window covers t, record the min slice and shrink l. Return \"\" if none. Time O(m+n). Not a unique-char max window, and not a word-length concatenation slide.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
