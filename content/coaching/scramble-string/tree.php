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
            'message' => "Problem: can s2 be obtained by recursively splitting s1 and optionally swapping the two halves? Same length. great vs rgeat → true. abcde vs caebd → false. Length ≤ 30.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Any permutation, or same letter counts like Group Anagrams', 'next' => 'anagram'],
                ['label' => 'Memo dfs(i, j, k): can s1[i..i+k) scramble into s2[j..j+k)', 'next' => 'dfs'],
            ],
        ],
        'anagram' => [
            'message' => "Same letters are required, but not enough: abcde and caebd share a multiset and still return false. A scramble only swaps whole substrings from binary splits, not arbitrary rearrangements.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Edit Distance: min inserts, deletes, replaces', 'next' => 'wrong_edit'],
                ['label' => 'Try each cut h: no-swap both halves, or swap then recurse', 'next' => 'dfs'],
            ],
        ],
        'wrong_edit' => [
            'message' => "You are wrong here.\nEdit Distance counts operations. This returns a boolean on a specific binary-swap grammar.\nStep back to when you reused Edit Distance.",
            'outcome' => 'wrong',
            'rewind_to' => 'anagram',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "When k == 1, return s1[i] == s2[j]. For k > 1, loop h from 1 to k-1. Why two pairings?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep order: dfs(i,j,h) and dfs(i+h,j+h,k-h). Swap: dfs(i+h,j,k-h) and dfs(i,j+k-h,h)', 'next' => 'ret'],
                ['label' => 'Only the no-swap pairing; swapping is just reversing the whole string', 'next' => 'wrong_noswap'],
            ],
        ],
        'wrong_noswap' => [
            'message' => "You are wrong. The problem may swap the two pieces at every split. great → rgeat swaps gr into rg; that is not a full reverse.\nStep back to when you dropped the swap case.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Cache dfs. Time O(n^4), space O(n^3). Single letter a vs a → true.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'dfs(0, 0, n) — a boolean, not an edit count', 'next' => 'success'],
                ['label' => 'Whether s2 is a subsequence of s1, like Unique Paths counting routes', 'next' => 'wrong_sub'],
            ],
        ],
        'wrong_sub' => [
            'message' => "You are wrong. Unique Paths counts grid walks. A scramble uses every character of s1 exactly once, with splits and optional swaps.\nStep back to when you treated this as a subsequence or path count.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs(i,j,k) with memo. Length 1 compares letters. Else try every h with keep-order or swap. Return dfs(0,0,n). O(n^4). Not anagram-only, not Edit Distance, not Unique Paths.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
