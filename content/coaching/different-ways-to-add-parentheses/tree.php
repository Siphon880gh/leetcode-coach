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
            'message' => "Problem: expression of digits and plus, minus, times. Return every value you can get by fully parenthesizing, any order. Length at most 20. \"2-1-1\" → [0, 2]. \"2×3-4×5\" includes two −10s.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Basic Calculator / II: one left-to-right or precedence pass; or Unique BST count of trees', 'next' => 'one'],
                ['label' => 'Split at each operator: dfs(left) × dfs(right) combined with that op; memoize the substring', 'next' => 'split'],
            ],
        ],
        'one' => [
            'message' => "One evaluation is one association. Unique BST counts shapes, not values. You need every split tree’s number.\nHow do you enumerate splits?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'If the slice is all digits, return [int]. Else for each operator, pair every left value with every right value', 'next' => 'split'],
                ['label' => 'Keep unique values only; drop the second −10 because it already appeared', 'next' => 'wrong_uniq'],
            ],
        ],
        'wrong_uniq' => [
            'message' => "You are wrong here.\nThe sample keeps duplicate results from different trees. Return the multiset, not a set.\nStep back to when you unique’d the list.",
            'outcome' => 'wrong',
            'rewind_to' => 'one',
            'choices' => [],
        ],
        'split' => [
            'message' => "Two-digit numbers exist, so “all digits” is safer than “length less than 3”. Memoize on the substring (or index bounds). Parentheses decide everything — no operator precedence.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '"2-1-1" → [0, 2]; "2×3-4×5" includes −34, −14, −10, −10, 10', 'next' => 'cpx'],
                ['label' => 'Always evaluate left-to-right so 2-1-1 is only 0', 'next' => 'wrong_ltr'],
            ],
        ],
        'wrong_ltr' => [
            'message' => "You are wrong. (2-(1-1)) is 2. Left-to-right misses that tree.\nStep back to when you used a single scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'split',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Exponential in operators, cut by memo. Output up to 10⁴ values. Not one Calculator pass, not Unique BST, not a unique set.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Split at operators and memoize; not one eval, not Catalan count, not unique-only', 'next' => 'success'],
                ['label' => 'Generate Parentheses strings, then eval each string with Basic Calculator', 'next' => 'wrong_gen'],
            ],
        ],
        'wrong_gen' => [
            'message' => "You are wrong. Generate Parentheses builds () strings, not splits of this expression. Split the given operators directly.\nStep back to when you generated parentheses.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs on each substring: digits → one number; else split at every operator and combine left and right lists. Keep duplicate values. Memoize. Not one Calculator pass, not Unique BST.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
