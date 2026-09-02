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
            'message' => "Problem: full match of s against p. '?' is any one character. '*' is any sequence, including empty. \"aa\" vs \"a\" → false. \"aa\" vs \"*\" → true. \"cb\" vs \"?a\" → false. Lengths ≤ 2000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reuse Regular Expression Matching: * means zero or more of the preceding token', 'next' => 'regex'],
                ['label' => 'Memo dfs(i, j): ? matches one char; * is skip or eat one s char and stay', 'next' => 'glob'],
            ],
        ],
        'regex' => [
            'message' => "Here * is a glob star, not x*. There is no preceding element. \"*\" alone matches \"aa\". Treating it as regex would look for a token before * and fail.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '? is the same as regex ".", so the two problems are identical', 'next' => 'wrong_same'],
                ['label' => 'dfs: if p[j] is *, try dfs(i, j+1) (empty) or dfs(i+1, j) (consume one); else one-char match including ?', 'next' => 'glob'],
            ],
        ],
        'wrong_same' => [
            'message' => "You are wrong here.\n? is like \".\", but * is not regex *. Regex a* cannot match \"bcd\". Glob * can.\nStep back to when you equated the problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'regex',
            'choices' => [],
        ],
        'glob' => [
            'message' => "If i is past s, remaining p must be skippable stars: j>=len(p) or (p[j]=='*' and dfs(i, j+1)). If j is past p while s remains, fail.\nWhy can leftover stars still succeed?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '* may match the empty sequence, so a suffix of only * still covers nothing', 'next' => 'example'],
                ['label' => '* must eat at least one character, so leftover * after s ends is always false', 'next' => 'wrong_empty'],
            ],
        ],
        'wrong_empty' => [
            'message' => "You are wrong. The problem states * includes the empty sequence. \"\" vs \"***\" is true.\nStep back to when you handled the s-exhausted case.",
            'outcome' => 'wrong',
            'rewind_to' => 'glob',
            'choices' => [],
        ],
        'example' => [
            'message' => "Cache (i, j). \"aa\" vs \"*\": star consumes both letters. \"cb\" vs \"?a\": ? takes c, then a≠b.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(m · n) time and O(m · n) memo space', 'next' => 'success'],
                ['label' => 'O(m + n) because each index is visited once without a grid', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. States are pairs (i, j). Without memo the * branch is exponential; with memo it is Θ(m · n).\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Memoized dfs. * is empty (j+1) or consume one s (i+1, same j). ? or equal letters take i+1, j+1. Exhausted s only matches leftover stars. Time and space O(m · n). Not regex *.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
