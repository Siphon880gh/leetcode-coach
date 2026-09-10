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
            'message' => "Problem: insert plus, minus, or times between digits of num so the expression equals target. \"123\" to 6 → 1×2×3 and 1+2+3. Operands may span digits. No leading zeros.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'eval every finished string after inserting operators', 'next' => 'wrong_eval'],
                ['label' => 'DFS operands; keep curr and last so times can undo the last addend', 'next' => 'dfs'],
            ],
        ],
        'wrong_eval' => [
            'message' => "You are wrong here.\neval is slow, easy to mishandle leading zeros, and not the intended path. Compute as you build.\nStep back to when you called eval.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "dfs(u, last, curr, path). Extend the next operand num[u..i]. If num[u] is 0 and i > u, stop. First operand: curr = last = next. Else plus (last = next), minus (last = −next), times: curr − last + last × next, last becomes last × next.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Times must undo last, else 2+3×2 becomes (2+3)×2', 'next' => 'cpx'],
                ['label' => 'Allow 05 as an operand; only skip 0 itself', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. 105 to 5 allows 1×0+5 and 10−5, not 1×05. A leading zero on a multi-digit operand is forbidden.\nStep back to when you allowed 05.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Exponential in n, n ≤ 10. Use 64-bit for next and curr. Space O(n).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DFS with last-operand times hook. No eval, no 05, no (a+b)×c for plus then times', 'next' => 'success'],
                ['label' => 'Only plus and minus; times can use the same running total as plus', 'next' => 'wrong_prec'],
            ],
        ],
        'wrong_prec' => [
            'message' => "You are wrong. Times binds tighter. You must keep last so you can replace it with last × next instead of multiplying the whole curr.\nStep back to when you reused plus’s running total for times.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. DFS digit spans. Times: curr − last + last × next. No leading zeros, no eval. \"123\" to 6 is 1×2×3 and 1+2+3.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
