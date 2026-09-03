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
            'message' => "Problem: fewest cuts so every piece is a palindrome. aab → 1 (aa|b). a → 0. ab → 1. n up to 2000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Partitioning I’s list of all cuts, Valid Palindrome’s boolean, or DFS of every partition (2^n)', 'next' => 'lists'],
                ['label' => 'Same palindrome table as I, then DP: f[i] = min cuts for the prefix ending at i', 'next' => 'dp'],
            ],
        ],
        'lists' => [
            'message' => "I returns [[a,a,b],[aa,b]]. n=2000 makes enumerating partitions too slow. You only need the smallest cut count.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Longest Palindromic Substring’s one window, or Edit Distance’s insert/delete/replace', 'next' => 'wrong_other'],
                ['label' => 'g[i][j] palindrome table; f[i] starts as i; if g[j][i] then f[i] = min(f[i], 0 if j==0 else 1+f[j-1])', 'next' => 'dp'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nLPS finds one substring. Edit Distance is a different DP. This is min cuts of palindromic pieces.\nStep back to when you copied those problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'lists',
            'choices' => [],
        ],
        'dp' => [
            'message' => "If the whole prefix s[0..i] is a palindrome, f[i]=0. Else a last palindrome s[j..i] costs 1 + f[j-1]. Time O(n²).\nWhy initialize f[i] = i?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Cutting after every character is always legal (single letters are palindromes), so it is a safe upper bound', 'next' => 'ret'],
                ['label' => 'Initialize f to 0 because a string always needs zero cuts', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. ab needs 1 cut. Starting at 0 would never rise unless you add, and the min with 0 stays 0.\nStep back to when you initialized f to 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return f[n-1], an integer.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '1, 0, and 1 on the samples — not [[aa,b], …] and not a boolean', 'next' => 'success'],
                ['label' => 'The partitions from Palindrome Partitioning I', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. II returns a cut count. The lists belong to I.\nStep back to when you returned partitions.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Palindrome table + f[i] min cuts. Init f[i]=i. Whole-prefix palindrome → 0. O(n²). Not Partitioning I’s lists, not Valid Palindrome, not LPS, not Edit Distance, not 2^n DFS.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
