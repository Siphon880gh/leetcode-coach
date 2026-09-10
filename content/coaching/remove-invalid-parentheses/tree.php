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
            'message' => "Problem: delete the fewest parentheses so the rest is valid. Return every unique valid string. \"()())()\" → \"(())()\" and \"()()()\". \")(\" → \"\". Letters stay.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat it as Valid Parentheses (20) yes/no, or Generate Parentheses (22) from empty', 'next' => 'wrong_kind'],
                ['label' => 'Count leftover ( and unmatched ); that pair is the exact delete budget', 'next' => 'count'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong here.\n20 only checks one string. 22 builds from scratch. Here you start from a dirty string and must not delete more than necessary.\nStep back to when you reused 20 or 22.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'count' => [
            'message' => "Scan: unmatched ) increments r. Leftover ( at the end is l. Any valid answer has length n − l − r. DFS index i with remaining l, r and prefix open/close counts. Skip a ( if l > 0, skip a ) if r > 0, always try keep. Letters always keep.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Drop letters, or return only one string when several minima exist', 'next' => 'wrong_drop'],
                ['label' => 'Prune if leftover chars cannot cover l + r, or if prefix close exceeds open', 'next' => 'prune'],
            ],
        ],
        'wrong_drop' => [
            'message' => "You are wrong. Letters never delete. The answer is every unique minimum, not a single example.\nStep back to when you dropped a letter or kept only one string.",
            'outcome' => 'wrong',
            'rewind_to' => 'count',
            'choices' => [],
        ],
        'prune' => [
            'message' => "Put answers in a set (duplicate skip paths). n ≤ 25, at most 20 parentheses. BFS one-deletion neighbors works but is slower.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Exact (l, r) budget, skip-or-keep DFS, prune invalid prefixes. Not 20, not 22', 'next' => 'success'],
                ['label' => 'Delete any number of parentheses as long as the result is valid', 'next' => 'wrong_any'],
            ],
        ],
        'wrong_any' => [
            'message' => "You are wrong. Only the fewest deletions. Extra removals make a shorter string and are not answers.\nStep back to when you allowed extra deletes.",
            'outcome' => 'wrong',
            'rewind_to' => 'prune',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Count extras, then skip-or-keep DFS with the exact budget. Prune invalid prefixes. Letters stay. Unique minima only. \"()())()\" has two answers.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
