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
            'message' => "Problem: numerator / denominator as a string. Wrap the repeating fractional digits in parentheses. 1/2 → 0.5. 2/1 → 2. 4/333 → 0.(012). Numerator 0 → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Language float, Compare Version dots, or always wrap the whole fraction in parens', 'next' => 'flt'],
                ['label' => 'Sign, integer part, then long division; hash remainder → index to detect a cycle', 'next' => 'div'],
            ],
        ],
        'flt' => [
            'message' => "Floats lose precision. Version strings are dotted ints, not division. Finite decimals must stay unwrapped (the note says so).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stop after the integer part even when a remainder remains', 'next' => 'wrong_int'],
                ['label' => 'After the dot, record each remainder’s position; if it repeats, insert ( at that index', 'next' => 'div'],
            ],
        ],
        'wrong_int' => [
            'message' => "You are wrong here.\n2/1 is just 2, but 1/2 still has remainder 1 and must emit .5.\nStep back to when you dropped the fraction.",
            'outcome' => 'wrong',
            'rewind_to' => 'flt',
            'choices' => [],
        ],
        'div' => [
            'message' => "XOR the signs for a leading minus. Use abs as longs. Append a//b; a %= b. If a is 0, return. Else \".\". While a: d[a] = len(ans); a *= 10; append a//b; a %= b; if a in d, insert \"(\" at d[a] and append \")\".\nFor 4/333, why parens around 012?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The remainder 4 shows up again after digits 0,1,2, so the cycle starts there', 'next' => 'ans'],
                ['label' => 'Every decimal is repeating; wrap 0.012 as (0.012)', 'next' => 'wrong_wrap'],
            ],
        ],
        'wrong_wrap' => [
            'message' => "You are wrong. Only the repeating run goes in parentheses, and 1/2 has no cycle.\nStep back to when you wrapped the whole number.",
            'outcome' => 'wrong',
            'rewind_to' => 'div',
            'choices' => [],
        ],
        'ans' => [
            'message' => "1/2 remainder hits 0 after 5, so 0.5 with no parens. 2/1 remainder 0 after the integer. Opposite signs get a minus.\nWhat is 2/1?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '2 — no decimal point', 'next' => 'success'],
                ['label' => '0.(012) from the other sample, or 2.0 with a forced point', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. An exact integer is the digits only. Do not reuse 4/333.\nStep back to when you scored 2/1.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sign, integer, then remainder map. Cycle → insert parentheses. Finite remainder 0 → stop. Not float, not Compare Version, not wrapping 0.5. 1/2 → 0.5. 4/333 → 0.(012).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
