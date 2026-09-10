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
            'message' => "Problem: digit string. True iff you can split into at least three numbers where each after the first two is the sum of the previous two. No leading zeros (1, 02, 3 is invalid; a lone 0 is fine). \"112358\" → true. \"199100199\" → true.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Check whether the whole string is a Fibonacci number F(n) (509)', 'next' => 'wrong_fib'],
                ['label' => 'Enumerate first two cuts; after that the next number is forced', 'next' => 'cuts'],
            ],
        ],
        'wrong_fib' => [
            'message' => "You are wrong here.\n509 asks F(n). This is a split of a digit string (same family as 842), yes/no, at least three numbers.\nStep back to when you reused Fibonacci Number.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'cuts' => [
            'message' => "Ends i and j for the first two (each length at least 1, leftover at least 1). Reject a multi-digit chunk that starts with 0. Then dfs(a, b, rest): empty rest → true. Else a+b must match a prefix of rest with no leading zero unless the sum is 0. Recurse dfs(b, a+b, rest after that prefix).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Allow 03, or accept a split with only two numbers', 'next' => 'wrong_zero'],
                ['label' => 'n ≤ 35; overflow follow-up: add digit strings, not 64-bit ints', 'next' => 'cpx'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. Numbers cannot have leading zeros. The first dfs call still has leftover digits, so empty rest means you already placed a third (or later) number.\nStep back to when you allowed 03 or stopped at two addends.",
            'outcome' => 'wrong',
            'rewind_to' => 'cuts',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Split Array into Fibonacci Sequence (842) returns one list; here you only need true/false. Same search.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'First two free, then forced sums. No leading zeros. At least three numbers', 'next' => 'success'],
                ['label' => 'Any two digits that add to a later digit is enough, even if the rest of the string is unused', 'next' => 'wrong_unused'],
            ],
        ],
        'wrong_unused' => [
            'message' => "You are wrong. The whole string must be consumed. Leftover unused digits fail.\nStep back to when you left a suffix unmatched.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Pick the first two splits. Each later number is a+b as a prefix of the rest. No 03. At least three. \"112358\" and \"199100199\" are true.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
