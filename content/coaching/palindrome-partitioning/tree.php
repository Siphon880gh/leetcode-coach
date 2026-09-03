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
            'message' => "Problem: every piece of a cut must be a palindrome; return all cuts. aab → [[a,a,b],[aa,b]]. a → [[a]]. n ≤ 16.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Valid Palindrome’s boolean, Palindrome Number, Longest Palindromic Substring, or min-cut Partitioning II', 'next' => 'bool'],
                ['label' => 'Precompute palindrome DP, then DFS: take s[i..j] only if it is a palindrome, pop on the way back', 'next' => 'dfs'],
            ],
        ],
        'bool' => [
            'message' => "Those problems return true, an integer, or one substring. Here you list every partition of the whole string.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Restore IP’s four octets, or Subsets’ take/skip without a palindrome check', 'next' => 'wrong_other'],
                ['label' => 'f[i][j] = (s[i]==s[j]) and f[i+1][j-1]; dfs(i) tries every palindromic end j', 'next' => 'dfs'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nRestore IP is four numeric chunks. Subsets ignores palindromes. This DFS only extends a palindromic prefix.\nStep back to when you copied those problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'bool',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "When i == n, append a copy of t. For j from i to n-1, if f[i][j], push s[i..j], dfs(j+1), pop. Fill f from longer i downward. Time O(n·2^n), extra O(n²).\nWhy copy t instead of appending t itself?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Later pops mutate t; ans would keep empty lists unless you snapshot t[:]', 'next' => 'ret'],
                ['label' => 'Sharing t is fine; the judge only reads after the search finishes', 'next' => 'wrong_copy'],
            ],
        ],
        'wrong_copy' => [
            'message' => "You are wrong. t is reused. Without a copy, every stored partition ends up as the same empty list.\nStep back to when you skipped the copy.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return a list of lists of strings.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Both [[a,a,b],[aa,b]] — not true, not a min cut of 1, not only [aa,b]', 'next' => 'success'],
                ['label' => 'The integer 1 (min extra cuts) from Palindrome Partitioning II', 'next' => 'wrong_cuts'],
            ],
        ],
        'wrong_cuts' => [
            'message' => "You are wrong. II asks for the fewest cuts. I asks for every partition.\nStep back to when you returned a cut count.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Palindrome table + DFS partitions + copy and pop. O(n·2^n). Not Valid Palindrome, not Palindrome Number, not LPS, not Partitioning II, not Restore IP, not Subsets.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
