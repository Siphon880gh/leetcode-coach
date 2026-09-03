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
            'message' => "Problem: insert dots so s becomes valid IPv4: four parts, each 0..255, no leading zeros. 25525511135 → 255.255.11.135 and 255.255.111.35. 0000 → 0.0.0.0. Length ≤ 20.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count partitions like Decode Ways (1–26), or parse one number like atoi', 'next' => 'decode'],
                ['label' => 'DFS four octets: try 1–3 digits from i; reject leading zeros and values > 255', 'next' => 'dfs'],
            ],
        ],
        'decode' => [
            'message' => "Decode Ways counts 1–26 letter codes. An IP needs exactly four 0–255 octets and dots. atoi reads one integer. You must not reorder digits.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Generate Parentheses: only prune by count of ( and )', 'next' => 'wrong_paren'],
                ['label' => 'dfs(i): for j in i .. min(i+2, n-1), if the slice is a legal octet, append, recurse j+1, pop', 'next' => 'dfs'],
            ],
        ],
        'wrong_paren' => [
            'message' => "You are wrong here.\nParentheses prune by balance. IP octets have a numeric range and a leading-zero rule.\nStep back to when you reused Generate Parentheses.",
            'outcome' => 'wrong',
            'rewind_to' => 'decode',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Why is 0.011.255.245 invalid, but 0.0.0.0 from 0000 valid?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A multi-digit octet cannot start with 0; a single 0 is allowed', 'next' => 'ret'],
                ['label' => 'Any run of zeros is one octet 0; leftover digits can be dropped', 'next' => 'wrong_drop'],
            ],
        ],
        'wrong_drop' => [
            'message' => "You are wrong. You may not remove digits. 0000 is four separate zeros, not one 0.\nStep back to when you dropped leftover digits.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Record when i == n and you already have four parts. If you run out of digits early or already have four parts with digits left, return. Time O(n·3^4).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'All dotted strings in any order — not a count, not one IP', 'next' => 'success'],
                ['label' => 'The number of ways, like Decode Ways f[n]', 'next' => 'wrong_count'],
            ],
        ],
        'wrong_count' => [
            'message' => "You are wrong. Decode Ways returns a count. Restore IP returns the actual addresses.\nStep back to when you returned a count.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs(0) with a path of four octets. Each slice is 1–3 digits, 0..255, no leading zero unless the octet is 0. Join with dots. Not Decode Ways, not atoi, not Generate Parentheses.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
