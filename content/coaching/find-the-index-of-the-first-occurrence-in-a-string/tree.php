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
            'message' => "Problem: return the first index of needle in haystack, or -1. haystack = \"sadbutsad\", needle = \"sad\" → 0. haystack = \"leetcode\", needle = \"leeto\" → -1. Lengths 1..10^4, lowercase.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Replace needle with a marker, then scan for the marker', 'next' => 'replace'],
                ['label' => 'For each start i in 0..n-m, compare haystack[i:i+m] to needle', 'next' => 'window'],
            ],
        ],
        'replace' => [
            'message' => "str_replace is not the matching algorithm: it mutates the string and can shift later indices. You want the first start where a window of length m equals needle.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only test whether haystack starts with needle; otherwise return -1', 'next' => 'wrong_prefix'],
                ['label' => 'Try every start i from 0 through n-m; return the first match, else -1', 'next' => 'window'],
            ],
        ],
        'wrong_prefix' => [
            'message' => "You are wrong here.\nhaystack = \"hello\", needle = \"ll\" starts at index 2, not at 0. A prefix check would miss it.\nStep back to when you chose how to search.",
            'outcome' => 'wrong',
            'rewind_to' => 'replace',
            'choices' => [],
        ],
        'window' => [
            'message' => "Let n = len(haystack), m = len(needle). A match that starts at i needs i+m-1 still inside haystack.\nWhat is the last legal i?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'i runs from 0 through n-m inclusive; that last window is haystack[n-m:n]', 'next' => 'example'],
                ['label' => 'Stop at n-m-1 so you never read the last character', 'next' => 'wrong_bound'],
            ],
        ],
        'wrong_bound' => [
            'message' => "You are wrong. haystack = \"abc\", needle = \"c\" matches only at i = 2 = n-m. Dropping that start returns -1.\nStep back to when you chose the loop range.",
            'outcome' => 'wrong',
            'rewind_to' => 'window',
            'choices' => [],
        ],
        'example' => [
            'message' => "\"sadbutsad\" / \"sad\": i=0 matches, return 0 (not 6). \"leetcode\" / \"leeto\": no window matches, return -1. Brute force is O((n-m+1)·m). KMP is O(n+m) if you need linear time.\nWhat is enough here?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O((n-m+1)·m) time, O(1) extra space is acceptable at n,m ≤ 10^4', 'next' => 'success'],
                ['label' => 'Must implement KMP or the judge will TLE', 'next' => 'wrong_kmp'],
            ],
        ],
        'wrong_kmp' => [
            'message' => "You are wrong. 10^4 · 10^4 is within typical limits. KMP (or Rabin–Karp) is the linear upgrade, not required for this problem.\nStep back to when you scored the scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Slide a window of length m. Return the first i where haystack[i:i+m] == needle, else -1. Time O((n-m+1)·m), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
