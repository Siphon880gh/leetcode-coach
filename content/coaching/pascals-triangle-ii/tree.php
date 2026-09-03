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
            'message' => "Problem: return the 0-indexed rowIndex-th row of Pascal’s triangle. 3 → [1,3,3,1]. 0 → [1]. 1 → [1,1]. rowIndex 0..33. Follow-up: O(rowIndex) extra space.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return all rows like Pascal I, or Unique Paths’ single integer', 'next' => 'all'],
                ['label' => 'Keep one array of 1s; grow the row in place, updating from right to left', 'next' => 'in'],
            ],
        ],
        'all' => [
            'message' => "Pascal I returns [[1],[1,1],…]. Unique Paths counts grid routes. Here you need one list, and you can reuse O(n) space.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Next Right II linking trees, or Distinct Subsequences of two strings', 'next' => 'wrong_tree'],
                ['label' => 'f = [1]*(rowIndex+1); for i in 2..rowIndex: for j from i-1 down to 1: f[j] += f[j-1]', 'next' => 'in'],
            ],
        ],
        'wrong_tree' => [
            'message' => "You are wrong here.\nThose problems are trees or string DP. This is one Pascal row.\nStep back to when you reused those problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'all',
            'choices' => [],
        ],
        'in' => [
            'message' => "Time O(n²), extra space O(n). Ends stay 1 because you never add into f[0].\nWhy walk j from the right instead of left to right?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'f[j] still holds the previous row until you write it; left-to-right would reuse already-updated cells', 'next' => 'ret'],
                ['label' => 'Direction does not matter; f[j] += f[j-1] is the same either way', 'next' => 'wrong_ltr'],
            ],
        ],
        'wrong_ltr' => [
            'message' => "You are wrong. Left-to-right, f[1] becomes 1+1=2 then f[2] uses that 2 instead of the old 1, so the row is wrong.\nStep back to when you scanned left to right.",
            'outcome' => 'wrong',
            'rewind_to' => 'in',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return f, a single list. Index 0 is [1], not [[1]].\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The one row [1,3,3,1], not Pascal I’s nested triangle', 'next' => 'success'],
                ['label' => 'All rows through rowIndex, like Pascal I with numRows = rowIndex+1', 'next' => 'wrong_nested'],
            ],
        ],
        'wrong_nested' => [
            'message' => "You are wrong. The sample is [1,3,3,1], not [[1],[1,1],[1,2,1],[1,3,3,1]].\nStep back to when you returned every row.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One array of 1s; update from the right. O(n²) time, O(n) extra. Not Pascal I’s full triangle, not Unique Paths, not Distinct Subsequences, not Next Right.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
