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
            'message' => "Problem: s = \"babad\". Return the longest palindromic substring (\"bab\" or \"aba\" both work).\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse every substring and compare — O(n³)', 'next' => 'brute'],
                ['label' => 'Table f[i][j]: is s[i..j] a palindrome?', 'next' => 'dp_def'],
            ],
        ],
        'brute' => [
            'message' => "n can be 1000, so O(n³) is too slow. A palindrome is a character plus a palindrome plus the same character.\nWhat is the recurrence?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'f[i][j] = (s[i] == s[j]) and f[i+1][j-1]; length 1 is already true', 'next' => 'dp_def'],
                ['label' => 'f[i][j] = f[0][j] and f[i][n-1] — prefix and suffix palindromes', 'next' => 'wrong_prefix'],
            ],
        ],
        'wrong_prefix' => [
            'message' => "You are wrong here.\nWhether the whole prefix or suffix is a palindrome does not tell you about s[i..j]. The inner interval is f[i+1][j-1].\nStep back to when you wrote the recurrence.",
            'outcome' => 'wrong',
            'rewind_to' => 'brute',
            'choices' => [],
        ],
        'dp_def' => [
            'message' => "s = \"cbbd\". Why is the answer \"bb\", not a single \"b\"?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Even-length palindromes count; two equal neighbors are a palindrome', 'next' => 'order'],
                ['label' => 'Palindromes must have a unique center character, so length is always odd', 'next' => 'wrong_odd'],
            ],
        ],
        'wrong_odd' => [
            'message' => "You are wrong. \"bb\" is a palindrome. The DP covers even length because f[i][i+1] is true when s[i]==s[i+1] (inner interval empty / already true).\nStep back to when you handled even length.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp_def',
            'choices' => [],
        ],
        'order' => [
            'message' => "f[i][j] reads f[i+1][j-1]. Which loop order fills the table correctly?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'i from n-2 down to 0; for each i, j from i+1 up to n-1', 'next' => 'track'],
                ['label' => 'i from 0 up; j from n-1 down — so the outer starts at the left', 'next' => 'wrong_order'],
            ],
        ],
        'wrong_order' => [
            'message' => "You are wrong. You need the longer-i (inner start) row computed first, so enumerate i from large to small and j from small to large.\nStep back to when you chose the fill order.",
            'outcome' => 'wrong',
            'rewind_to' => 'order',
            'choices' => [],
        ],
        'track' => [
            'message' => "Keep start k and length mx (initially 0 and 1). When f[i][j] is true and j−i+1 > mx, set k=i and mx=j−i+1.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 's[k : k+mx] — the recorded longest slice', 'next' => 'success'],
                ['label' => 'The whole string, because every character is a palindrome', 'next' => 'wrong_whole'],
            ],
        ],
        'wrong_whole' => [
            'message' => "You are wrong. Singletons give mx=1; you only extend mx when a longer palindrome is proven. \"babad\" is not a palindrome, so you return a slice of length 3.\nStep back to when you recorded the answer.",
            'outcome' => 'wrong',
            'rewind_to' => 'track',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Interval DP: f[i][j] = (s[i]==s[j]) and f[i+1][j-1], fill i downward, track the longest true interval. Time and space O(n²).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
