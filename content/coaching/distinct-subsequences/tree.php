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
            'message' => "Problem: count distinct subsequences of s that equal t. s=rabbbit, t=rabbit → 3. s=babgbag, t=bag → 5. Lengths up to 1000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Interleaving String’s boolean, or Edit Distance’s min operations', 'next' => 'bool'],
                ['label' => 'DP f[i][j]: ways the first i of s form the first j of t', 'next' => 'dp'],
            ],
        ],
        'bool' => [
            'message' => "Interleaving is true/false on two sources. Edit Distance is a min cost. This returns a count of subsequences (keep order, skip letters).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Unique Paths grid counts, or Flatten Tree into a right spine', 'next' => 'wrong_grid'],
                ['label' => 'f[i][0]=1; skip always f[i-1][j]; if s[i-1]==t[j-1] also add f[i-1][j-1]', 'next' => 'dp'],
            ],
        ],
        'wrong_grid' => [
            'message' => "You are wrong here.\nUnique Paths counts down/right walks. Flatten rewires a tree. This is 2D string DP on prefixes of s and t.\nStep back to when you reused those problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'bool',
            'choices' => [],
        ],
        'dp' => [
            'message' => "f[i][j] = f[i-1][j], plus f[i-1][j-1] when the letters match. Time O(m·n). Empty t is 1 way (take nothing).\nWhy is f[i][0] = 1 for every i?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'There is one way to form the empty string: skip every letter of s', 'next' => 'ret'],
                ['label' => 'Empty t should be 0 because there is no subsequence to match', 'next' => 'wrong_empty'],
            ],
        ],
        'wrong_empty' => [
            'message' => "You are wrong. The empty target is formed exactly once by taking no characters. Base f[*][0]=1 is what lets later matches add.\nStep back to when you zeroed the empty target.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return f[m][n], an integer that fits in 32-bit signed. Not a boolean and not a min distance.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The number of ways, not Unique BST I’s Catalan f[n] on tree counts', 'next' => 'success'],
                ['label' => 'true if t is a subsequence at least once, like Interleaving', 'next' => 'wrong_bool'],
            ],
        ],
        'wrong_bool' => [
            'message' => "You are wrong. The sample needs 3 and 5, not true. You count every way, including the three ways to pick b’s in rabbbit.\nStep back to when you returned a boolean.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. f[i][0]=1; skip or take-on-match. Return f[m][n]. O(m·n). Not Interleaving, not Edit Distance, not Unique Paths, not Unique BST I, not Flatten Tree.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
