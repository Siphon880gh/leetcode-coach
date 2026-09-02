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
            'message' => "Problem: compute x^n. n is a 32-bit integer (can be negative). 2^10 → 1024. 2^-2 → 0.25. |n| up to 2^31.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Multiply x into ans, n times, or call the language pow', 'next' => 'naive'],
                ['label' => 'Fast pow: while n: if n&1 then ans*=a; a*=a; n>>=1. If n<0, return 1/qpow(x, -n)', 'next' => 'qpow'],
            ],
        ],
        'naive' => [
            'message' => "A loop of |n| multiplies is O(|n|). n can be two billion. Library pow is not the algorithm this problem asks you to implement.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Recurse x^n = x * x^(n-1); that is still linear in n', 'next' => 'wrong_lin'],
                ['label' => 'Square the base and halve the exponent (binary bits of n)', 'next' => 'qpow'],
            ],
        ],
        'wrong_lin' => [
            'message' => "You are wrong here.\nEach recursive step only drops n by 1, so the stack and the work are still Θ(|n|).\nStep back to when you chose the recurrence.",
            'outcome' => 'wrong',
            'rewind_to' => 'naive',
            'choices' => [],
        ],
        'qpow' => [
            'message' => "For n < 0 you return 1 / qpow(x, -n). In 32-bit languages, why might -n itself overflow?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'n can be -2^31; negating INT_MIN does not fit in 32-bit signed; use a wider type for the exponent', 'next' => 'example'],
                ['label' => 'Negative n means the answer is -x^|n|, so you never negate n', 'next' => 'wrong_neg'],
            ],
        ],
        'wrong_neg' => [
            'message' => "You are wrong. 2^-2 is +0.25, not -4. Negative exponent is reciprocal, not a sign flip.\nStep back to when you handled n < 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'qpow',
            'choices' => [],
        ],
        'example' => [
            'message' => "qpow: ans=1. While n: if the low bit is 1, ans*=a; always a*=a and n>>=1. 2^10 uses bits of 10 (1010b) → 1024. Then 1/qpow for negatives.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(log |n|) time, O(1) extra (iterative)', 'next' => 'success'],
                ['label' => 'O(|n|) because a*=a still runs once per original exponent', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. Each iteration halves n (right shift). The loop body runs Θ(log |n|) times.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Iterative binary exponentiation. Odd bits multiply into ans; square the base. Negative n → reciprocal, with INT_MIN taken as a wider exponent. Time O(log |n|), extra O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
