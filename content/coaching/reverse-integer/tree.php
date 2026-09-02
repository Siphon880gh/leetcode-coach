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
            'message' => "Problem: reverse the digits of a signed 32-bit int x. 123 → 321, −123 → −321, 120 → 21. If the reverse is outside [−2³¹, 2³¹−1], return 0. You may not store 64-bit integers.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Turn x into a string, reverse it, parse back', 'next' => 'as_string'],
                ['label' => 'Pop the last digit with % 10 and push it onto ans', 'next' => 'math'],
            ],
        ],
        'as_string' => [
            'message' => "A string reverse handles 120 → 21, but parsing can still overflow, and the prompt forbids 64-bit storage.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Parse as 64-bit, then clamp into 32-bit', 'next' => 'wrong_64'],
                ['label' => 'Build ans digit by digit and reject before ans × 10 + y would leave 32-bit', 'next' => 'math'],
            ],
        ],
        'wrong_64' => [
            'message' => "You are wrong here.\nYou are not allowed to form a 64-bit intermediate. Check the next digit against the 32-bit bounds before multiplying.\nStep back to when you chose how to reverse.",
            'outcome' => 'wrong',
            'rewind_to' => 'as_string',
            'choices' => [],
        ],
        'math' => [
            'message' => "Loop: y = last digit of x, then ans = ans × 10 + y, then drop that digit of x.\nWhy compare ans to mx//10 (and mi//10) *before* multiplying?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'If ans is already past mx//10, ans × 10 overflows 32-bit — you cannot even compute it', 'next' => 'sign'],
                ['label' => 'Multiply first, then see if the product looks too big', 'next' => 'wrong_after'],
            ],
        ],
        'wrong_after' => [
            'message' => "You are wrong. After multiplying you have already left 32-bit. The check is ans > mx//10 (or ans < mi//10) *before* ans × 10 + y.\nStep back to when you placed the overflow test.",
            'outcome' => 'wrong',
            'rewind_to' => 'math',
            'choices' => [],
        ],
        'sign' => [
            'message' => "x = −123 should become −321. Trailing zeros in 120 vanish because they become leading zeros in ans.\nWhat happens to the sign?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep x’s sign: negative remainders (or Python’s % adjust) push negative digits into ans', 'next' => 'overflow'],
                ['label' => 'Always build a positive reverse, then the caller adds a minus if they remember', 'next' => 'wrong_sign'],
            ],
        ],
        'wrong_sign' => [
            'message' => "You are wrong. The loop itself must produce a negative ans for negative x. Don’t drop the sign into a side flag that you might forget.\nStep back to when you handled negatives.",
            'outcome' => 'wrong',
            'rewind_to' => 'sign',
            'choices' => [],
        ],
        'overflow' => [
            'message' => "If the reversed value would sit outside [−2³¹, 2³¹−1], what do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '0 — do not clamp to the 32-bit min or max', 'next' => 'success'],
                ['label' => 'Saturate to −2³¹ or 2³¹−1', 'next' => 'wrong_sat'],
            ],
        ],
        'wrong_sat' => [
            'message' => "You are wrong. Overflow means return 0, not a clamped extreme.\nStep back to when you defined the overflow result.",
            'outcome' => 'wrong',
            'rewind_to' => 'overflow',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Pop digits, push onto ans, abort with 0 if ans is already outside [mi//10, mx//10]. Time O(log |x|), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
