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
            'message' => "Problem: longest contiguous subarray summing to k; 0 if none. nums may be negative. [1,−1,5,−2,3], k=3 → 4 ([1,−1,5,−2]). Length up to 2e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Two-pointer shrink (209) or count how many subarrays hit k (560)', 'next' => 'wrong_209'],
                ['label' => 'Prefix s; map the first index of each prefix; length = i − d[s − k]', 'next' => 'prefix'],
            ],
        ],
        'wrong_209' => [
            'message' => "You are wrong here.\n209 needs positive numbers so the window is monotone. 560 counts hits. Negatives break a shrink window, and this problem wants max length, not a count.\nStep back to when you used 209 or 560.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'prefix' => [
            'message' => "d[0] = −1 so a prefix that itself equals k has length i − (−1). At i, if s−k is in d, ans = max(ans, i − d[s−k]). Then store d[s] = i only if s is new. Keeping the earliest s maximizes later lengths.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Overwrite d[s] every time, or forget d[0] = −1', 'next' => 'wrong_map'],
                ['label' => 'O(n) time and space. Return 0 when nothing hits k', 'next' => 'cpx'],
            ],
        ],
        'wrong_map' => [
            'message' => "You are wrong. A later same prefix shortens the span. Missing d[0]=−1 drops subarrays that start at index 0.\nStep back to when you overwrote the first index or skipped the −1 seed.",
            'outcome' => 'wrong',
            'rewind_to' => 'prefix',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "n is 2e5, so nested scans are too slow.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'First prefix of s−k. Longest length, not a count. Not 209', 'next' => 'success'],
                ['label' => 'Return the sum of that longest subarray instead of its length', 'next' => 'wrong_sum'],
            ],
        ],
        'wrong_sum' => [
            'message' => "You are wrong. The answer is a length (or 0), not the sum k again.\nStep back to when you returned a sum.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. First occurrence of each prefix; length i − d[s−k]. Seed d[0]=−1. Negatives block 209. Not 560.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
