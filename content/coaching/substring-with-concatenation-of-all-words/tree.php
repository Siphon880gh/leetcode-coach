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
            'message' => "Problem: s = \"barfoothefoobarman\", words = [\"foo\",\"bar\"]. All words have equal length k. Return every start index of a substring that is some permutation of words concatenated. Output [0,9]. n up to 5000, |s| up to 10^4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Generate every permutation of words, then search each concat in s', 'next' => 'perms'],
                ['label' => 'Count words; slide a window of n chunks of length k', 'next' => 'window'],
            ],
        ],
        'perms' => [
            'message' => "n! concatenations is impossible at n = 5000. You only need the multiset of words, not an ordered list of perms.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'At every index i, DFS unused words until the concat matches or fails', 'next' => 'wrong_perm'],
                ['label' => 'Hash counts; advance the right edge by k; shrink or reset when counts break', 'next' => 'window'],
            ],
        ],
        'wrong_perm' => [
            'message' => "You are wrong here.\nSearching permutations (or DFS of unused words at every i) is still factorial or O(|s| · n · k) with huge n. Use a sliding count of word-chunks.\nStep back to when you chose how to search.",
            'outcome' => 'wrong',
            'rewind_to' => 'perms',
            'choices' => [],
        ],
        'window' => [
            'message' => "A match can start at any index, not only multiples of k from 0. If s = \"xbarfoo\" and words = [\"foo\",\"bar\"], the hit is at 1.\nHow many windows do you run?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'k residue classes: for i in 0..k-1, take chunks s[i], s[i+k], s[i+2k], …', 'next' => 'counts'],
                ['label' => 'One scan from index 0 in steps of k — words only line up with the start of s', 'next' => 'wrong_align'],
            ],
        ],
        'wrong_align' => [
            'message' => "You are wrong. Concatenations are not required to start on a multiple of k from 0. The k offsets cover every possible start.\nStep back to when you chose the alignment.",
            'outcome' => 'wrong',
            'rewind_to' => 'window',
            'choices' => [],
        ],
        'counts' => [
            'message' => "Let cnt be Counter(words) (duplicates matter). In each residue, grow r by k. Unknown chunk → reset l to r and clear the window counts. Too many of word t → advance l by k until cnt1[t] ≤ cnt[t]. When r-l == n·k, record l.\nWhy not a set of words?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'words may repeat; a set would under-count (example: two \"word\" entries)', 'next' => 'success'],
                ['label' => 'A set is enough because each distinct word appears at most once in a concat', 'next' => 'wrong_set'],
            ],
        ],
        'wrong_set' => [
            'message' => "You are wrong. words = [\"word\",\"good\",\"best\",\"word\"] needs two copies of \"word\". A set would treat that as three words and accept the wrong window length.\nStep back to when you chose the frequency map.",
            'outcome' => 'wrong',
            'rewind_to' => 'counts',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Counter of words, then k sliding windows that step by k. Reset on an unknown chunk; shrink when a word is overused; record l when the window holds exactly n words. Time O(|s| · k), space O(n · k).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
