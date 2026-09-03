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
            'message' => "Problem: return every way to insert spaces so each piece is in the dict (any order). Reuse allowed. catsanddog with [cat, cats, and, sand, dog] → [cats and dog, cat sand dog]. catsandog → []. n ≤ 20.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Word Break I’s f[n] boolean, Word Ladder II’s BFS paths, or greedy one longest split', 'next' => 'bool'],
                ['label' => 'Trie (or set) of words, then DFS prefixes: if s[:i] is a word, prepend it onto dfs(s[i:])', 'next' => 'dfs'],
            ],
        ],
        'bool' => [
            'message' => "f[n] only says whether a split exists. This problem wants the sentences. Word Ladder II is a different graph. Greedy keeps one split.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Palindrome Partitioning’s palindrome table, or Decode Ways’ count of mappings', 'next' => 'wrong_other'],
                ['label' => 'DFS every dict prefix; empty remainder yields one empty word-list so join can finish', 'next' => 'dfs'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nCuts must be dictionary words, not palindromes. The return type is List[str] sentences, not a count.\nStep back to when you copied those APIs.",
            'outcome' => 'wrong',
            'rewind_to' => 'bool',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "if not s: return [[]]. For i=1..len(s): if search(s[:i]): for v in dfs(s[i:]): append [s[:i]]+v. Then join each list with a space.\nWhy return [[]] on empty, not []?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[[]] is one successful empty tail so a complete prefix can join; [] would drop every path', 'next' => 'ret'],
                ['label' => '[] is enough, because there are no more words to add', 'next' => 'wrong_empty'],
            ],
        ],
        'wrong_empty' => [
            'message' => "You are wrong. Returning [] from the empty string means no completions, so every prefix path dies. You need one empty list to concatenate onto.\nStep back to when you returned [].",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "n is only 20, so exploring prefixes is fine. Impossible strings yield []. Join with a single space between words.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A list of space-joined sentences — not true/false, not nested palindrome cuts', 'next' => 'success'],
                ['label' => 'true if the list is nonempty, like Word Break I', 'next' => 'wrong_bool'],
            ],
        ],
        'wrong_bool' => [
            'message' => "You are wrong. Word Break I is the boolean. Here the judge wants the sentences themselves.\nStep back to when you collapsed the list.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Trie/set + DFS prefixes; empty tail is [[]]; join with spaces. All sentences, reuse allowed. Not Word Break I’s boolean, not Word Ladder II, not greedy one split, not palindrome partitions, not Decode Ways counts.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
