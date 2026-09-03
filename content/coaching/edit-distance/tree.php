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
            'message' => "Problem: min operations to turn word1 into word2. Ops: insert, delete, replace one char. \"horse\" → \"ros\" is 3. Lengths ≤ 500.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy Regular Expression Matching: DFS on . and * for a boolean match', 'next' => 'regex'],
                ['label' => 'DP: f[i][j] = min ops for prefixes i and j; equal copies diagonal; else min of three neighbors + 1', 'next' => 'dp'],
            ],
        ],
        'regex' => [
            'message' => "Regex matching returns true/false on a pattern. Edit distance returns a count. There is no * or . here.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return whether the two strings already match', 'next' => 'wrong_bool'],
                ['label' => 'f[i][j] is the min cost to convert the first i chars of word1 into the first j of word2', 'next' => 'dp'],
            ],
        ],
        'wrong_bool' => [
            'message' => "You are wrong here.\n\"horse\" and \"ros\" do not match, but the answer is 3, not false.\nStep back to when you treated this as a boolean.",
            'outcome' => 'wrong',
            'rewind_to' => 'regex',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Why is f[i][0] = i and f[0][j] = j?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Empty target needs i deletes; empty source needs j inserts', 'next' => 'ops'],
                ['label' => 'Empty prefixes cost 0; you can jump to any string for free', 'next' => 'wrong_base'],
            ],
        ],
        'wrong_base' => [
            'message' => "You are wrong. Turning \"abc\" into \"\" takes 3 deletes. The first row and column are not zeros.\nStep back to when you zeroed the borders.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'ops' => [
            'message' => "When the current letters differ, min of f[i-1][j] (delete), f[i][j-1] (insert), f[i-1][j-1] (replace), then +1. Equal letters copy f[i-1][j-1] with no extra cost. Time O(m·n).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'f[m][n], the min operation count — not a boolean, and not Unique Paths', 'next' => 'success'],
                ['label' => 'The length of the longest common subsequence', 'next' => 'wrong_lcs'],
            ],
        ],
        'wrong_lcs' => [
            'message' => "You are wrong. LCS length is not the edit distance. Replace costs 1 here, not two insert/deletes.\nStep back to when you returned LCS.",
            'outcome' => 'wrong',
            'rewind_to' => 'ops',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. f[i][0]=i, f[0][j]=j. Equal letters copy the diagonal. Else min(delete, insert, replace)+1. Return f[m][n]. Time O(m·n). Levenshtein count — not regex matching, and not LCS length.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
