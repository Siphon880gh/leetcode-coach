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
            'message' => "Problem: quotient of dividend / divisor without *, /, or %. Truncate toward zero. 10 / 3 → 3. 7 / -3 → -2. 32-bit signed only; clamp if the true quotient is outside [-2³¹, 2³¹−1]. divisor ≠ 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Subtract |divisor| once per loop until the remainder is smaller', 'next' => 'linear'],
                ['label' => 'Double the divisor with left shifts (binary long division), then handle sign', 'next' => 'binary'],
            ],
        ],
        'linear' => [
            'message' => "One subtract per loop is O(|quotient|). INT_MIN / 1 does about 2³¹ steps and times out. Fast exponentiation: peel off the largest 2^k · divisor that still fits.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Negate both to positives first so comparisons are easier', 'next' => 'wrong_pos'],
                ['label' => 'Work in the negative domain; double x and cnt with << while 2x still fits', 'next' => 'binary'],
            ],
        ],
        'wrong_pos' => [
            'message' => "You are wrong here.\nNegating INT_MIN overflows 32-bit (there is no +2147483648). Convert both operands to negatives, then compare with <=.\nStep back to when you chose the number domain.",
            'outcome' => 'wrong',
            'rewind_to' => 'linear',
            'choices' => [],
        ],
        'binary' => [
            'message' => "Special case: dividend = -2³¹ and divisor = -1. The true quotient is 2³¹, which is not a 32-bit signed int.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '2³¹−1 — the problem clamps a too-large quotient to INT_MAX', 'next' => 'example'],
                ['label' => '0 — same overflow rule as reverse-integer', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. This problem saturates: too big → 2³¹−1, too small → -2³¹. Reverse-integer’s return-0 rule does not apply.\nStep back to when you handled INT_MIN / -1.",
            'outcome' => 'wrong',
            'rewind_to' => 'binary',
            'choices' => [],
        ],
        'example' => [
            'message' => "10 and 3, both made negative: -10, -3. Double -3 → -6 (cnt=2); -12 does not fit. Subtract -6, remainder -4, then one more -3 (cnt=1). ans = 3. Same signs stay non-negative. 7 / -3 truncates toward zero to -2, not down to -3.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(log |a| · log |b|) time, O(1) extra space', 'next' => 'success'],
                ['label' => 'O(|a| / |b|) even with doubling, because you still subtract once per unit', 'next' => 'wrong_linear'],
            ],
        ],
        'wrong_linear' => [
            'message' => "You are wrong. Each inner loop doubles the chunk, so you subtract exponentially larger pieces. That is logarithmic in |a| and |b|, not linear in the quotient.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Clamp INT_MIN / -1. Stay in negatives. Repeatedly subtract the largest doubled divisor that fits. Apply the sign. Time O(log |a| · log |b|), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
