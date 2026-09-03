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
            'message' => "Problem: evaluate Reverse Polish tokens. Operators are +, -, *, /. Division truncates toward zero. Valid expression, 32-bit ints. 2, 1, +, 3, * → 9. 4, 13, 5, /, + → 6.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Parse infix with parentheses, Valid Parentheses matching, Max Points slopes, or Simplify Path names', 'next' => 'infix'],
                ['label' => 'Stack: push numbers; on an operator pop y then x, push x op y', 'next' => 'stk'],
            ],
        ],
        'infix' => [
            'message' => "RPN already encodes order; there are no parentheses to match. Valid Parentheses, Max Points, and Simplify Path are different problems.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Recurse like a binary tree path sum, treating * as a bend', 'next' => 'wrong_tree'],
                ['label' => 'One stack of ints; operators consume the last two values', 'next' => 'stk'],
            ],
        ],
        'wrong_tree' => [
            'message' => "You are wrong here.\nMax path sum bends at a tree node. RPN is a linear token scan with a stack, not a binary tree walk.\nStep back to when you reused a tree path.",
            'outcome' => 'wrong',
            'rewind_to' => 'infix',
            'choices' => [],
        ],
        'stk' => [
            'message' => "Pop y first (top), then x. Push x+y, x-y, x*y, or trunc(x/y). A lone - is the operator; -11 is a number (length > 1). After 2, 1, + the stack is 3; then 3, * makes 9.\nWhy y first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The top is the right operand; 13 then 5 then / is 13/5, not 5/13', 'next' => 'ret'],
                ['label' => 'Order never matters; + and * commute so always pop x then y', 'next' => 'wrong_order'],
            ],
        ],
        'wrong_order' => [
            'message' => "You are wrong. Subtraction and division are not commutative. Top of stack is the second operand.\nStep back to when you swapped x and y.",
            'outcome' => 'wrong',
            'rewind_to' => 'stk',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Python int(truediv) or C++ toward-zero int divide: 13/5 is 2, and 6/-132 is 0, which is why the long sample ends at 22. Return the one remaining stack value. Time O(n), extra O(n).\nWhat does 4, 13, 5, /, + return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '6 — 13/5 truncates to 2, then 4+2', 'next' => 'success'],
                ['label' => '9, like the first sample, or 2.6 without truncating', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. That input is 4 + (13/5) = 6, not 9, and not a float.\nStep back to when you mixed the samples or skipped truncate-toward-zero.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Stack numbers; pop y then x on an operator; toward-zero divide. O(n). Not infix, not Valid Parentheses, not Simplify Path, not Max Points, not tree path sum. Lone - vs negative numbers.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
