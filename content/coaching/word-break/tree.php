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
            'message' => "Problem: return true if s can be split into one or more dictionary words. Reuse is allowed. leetcode with [leet, code] → true. applepenapple with [apple, pen] → true. catsandog with [cats, dog, sand, and, cat] → false. n up to 300.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Word Ladder’s BFS, Word Break II’s list of sentences, greedy longest match, or require using every dict word', 'next' => 'other'],
                ['label' => 'Set of words. f[0]=true. f[i] is true if some j < i has f[j] and s[j:i] in the set', 'next' => 'dp'],
            ],
        ],
        'other' => [
            'message' => "This is a boolean, not the sentences. Word Ladder changes letters. Greedy longest on catsandog can eat cat then sand and get stuck even when another split might work — here it is false anyway, but greedy is still the wrong algorithm. You may skip unused dict words.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Decode Ways’ 1-or-2 digit DP, or Palindrome Partitioning’s every palindrome cut', 'next' => 'wrong_other'],
                ['label' => 'f[i] means the prefix of length i can be segmented; try every split j', 'next' => 'dp'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nDecode Ways uses digit rules, not a word set. Palindrome Partitioning lists cuts, not a boolean cover.\nStep back to when you copied those DPs.",
            'outcome' => 'wrong',
            'rewind_to' => 'other',
            'choices' => [],
        ],
        'dp' => [
            'message' => "words = set(wordDict). Loop i from 1 to n; f[i] = any(f[j] and s[j:i] in words). Return f[n].\nWhy f[0] = true?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The empty prefix is segmented; it lets a dict word that matches s[0:i] start the string', 'next' => 'ret'],
                ['label' => 'f[0] should be false, because the empty string is not in the dictionary', 'next' => 'wrong_f0'],
            ],
        ],
        'wrong_f0' => [
            'message' => "You are wrong. The empty prefix is a valid base so the first word can attach. The dictionary does not need to contain the empty string.\nStep back to when you zeroed f[0].",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Time about O(n²) substring checks. leetcode: f at 4 and 8 become true. catsandog never reaches n. Reuse is free because a word can match many slices.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'f[n], a boolean — not the list of splits', 'next' => 'success'],
                ['label' => 'The count of ways, like Decode Ways', 'next' => 'wrong_count'],
            ],
        ],
        'wrong_count' => [
            'message' => "You are wrong. Word Break is true/false, not the number of segmentations (that is closer to Decode Ways).\nStep back to when you returned a count.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Hash the dict. f[0]=true; f[i] if a segmented prefix plus a dict slice reaches i. Return f[n]. Reuse allowed. Not Word Break II, not Word Ladder, not greedy longest, not Decode Ways counts, not palindrome cuts.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
