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
            'message' => "Problem: is s3 an interleaving of s1 and s2? aabcc and dbbca make aadbbcbcac (true) but not aadbbbaccc (false). Empty, empty, empty → true. Lengths up to 100 + 100.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Concatenate s1+s2, or Unique Paths counting grid walks', 'next' => 'concat'],
                ['label' => 'If m+n ≠ |s3| return false; else memo dfs(i, j) on remaining prefixes', 'next' => 'dfs'],
            ],
        ],
        'concat' => [
            'message' => "s1+s2 is one order, not every mix. Unique Paths counts routes; this returns a boolean. Greedy “take the first matching letter” also fails on aadbbbaccc.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Scramble String: split and maybe swap whole halves', 'next' => 'wrong_scramble'],
                ['label' => 'At s3[i+j], try s1[i] if it matches, else/also s2[j]; cache (i, j)', 'next' => 'dfs'],
            ],
        ],
        'wrong_scramble' => [
            'message' => "You are wrong here.\nA scramble rewrites one string by swapping halves. An interleave consumes two strings in order, never rearranging letters inside s1 or s2.\nStep back to when you reused Scramble String.",
            'outcome' => 'wrong',
            'rewind_to' => 'concat',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "dfs(i, j): if i≥m and j≥n, true. k = i+j. Recurse i+1 when s1[i]==s3[k], and/or j+1 when s2[j]==s3[k]. Memo. Time O(m·n).\nWhy try both when both letters match?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Either source may be the one that unlocks a later letter; greedy first-match can fail', 'next' => 'ret'],
                ['label' => 'Always consume s1 first when both match, like Unique Paths only going right', 'next' => 'wrong_greedy'],
            ],
        ],
        'wrong_greedy' => [
            'message' => "You are wrong. Preferring s1 whenever it matches can block s2 later. You OR both branches, with memo so overlapping prefixes are not re-walked.\nStep back to when you always took s1 first.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return dfs(0, 0) after the length check. Not a path count.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A boolean: can the two leftovers form the rest of s3', 'next' => 'success'],
                ['label' => 'How many interleavings, like Unique Paths or Unique BSTs', 'next' => 'wrong_count'],
            ],
        ],
        'wrong_count' => [
            'message' => "You are wrong. Unique Paths and Unique BSTs return counts. This problem asks whether any interleave exists.\nStep back to when you returned a count.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Length must match. Memo dfs(i, j): take s1[i] or s2[j] when it equals s3[i+j]. Return dfs(0, 0). O(m·n). Not concatenate, not greedy, not Scramble String, not Unique Paths.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
