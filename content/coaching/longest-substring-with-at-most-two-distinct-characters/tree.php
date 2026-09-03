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
            'message' => "Problem: longest substring with at most two distinct characters. eceba → 3 (ece). ccaabbb → 5 (aabbb). n can be 10⁵.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Same as LC 3: shrink whenever any letter repeats, or scan every substring', 'next' => 'lc3'],
                ['label' => 'Sliding window: expand i, shrink j while the count map has more than 2 keys', 'next' => 'win'],
            ],
        ],
        'lc3' => [
            'message' => "LC 3 forbids any duplicate. Here ece is valid: two letters, c repeats. Brute O(n²) is too slow at 10⁵.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep a unique window like LC 3; ece would be illegal', 'next' => 'wrong_unique'],
                ['label' => 'Count frequencies in [j, i]; shrink only while more than two distinct keys', 'next' => 'win'],
            ],
        ],
        'wrong_unique' => [
            'message' => "You are wrong here.\nRepeats of the same two letters are allowed. The invariant is at most two keys, not all counts equal to 1.\nStep back to when you mixed this with no-repeat.",
            'outcome' => 'wrong',
            'rewind_to' => 'lc3',
            'choices' => [],
        ],
        'win' => [
            'message' => "For each i: cnt[c] += 1. While len(cnt) > 2: decrement s[j], pop the key if its count hits 0, then j += 1. Then ans = max(ans, i - j + 1).\nOn eceba, after e,c,e the map has two keys and ans is 3. Then b makes three. What happens?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Advance j past the first e then c; window is eb; ans stays 3 from ece', 'next' => 'ans'],
                ['label' => 'Reset j to i so the window is only b; forget that ece already scored 3', 'next' => 'wrong_reset'],
            ],
        ],
        'wrong_reset' => [
            'message' => "You are wrong. j only moves forward. You drop the leftover that made three keys, then keep the running max. Jumping j to i throws away work.\nStep back to when the third letter arrived.",
            'outcome' => 'wrong',
            'rewind_to' => 'win',
            'choices' => [],
        ],
        'ans' => [
            'message' => "ccaabbb: after the last b the window is aabbb — two keys, length 5. Time O(n), space O(|Σ|).\nWhat is eceba?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '3 — ece, not the whole string and not a subsequence like eea', 'next' => 'success'],
                ['label' => '5 like ccaabbb, or 4 treating eeba as contiguous', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. eceba yields 3. Mixing in the other sample or skipping the middle c is not a substring.\nStep back to when you scored eceba.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Expand, shrink while more than two distinct characters, record i - j + 1. Not LC 3 (no repeats), not Read4 leftovers, not a subsequence. eceba → 3. ccaabbb → 5.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
