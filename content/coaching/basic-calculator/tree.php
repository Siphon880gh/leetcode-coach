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
            'message' => "Problem: valid expression of digits, plus, minus, parens, spaces. No eval. Return the integer. n up to 3 × 10⁵. \"1 + 1\" → 2. \" 2-1 + 2 \" → 3. \"(1+(4+5+2)-3)+(6+8)\" → 23. Unary minus OK; unary plus is not.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'eval(s), or Basic Calculator II times/divide with no parens, or RPN postfix', 'next' => 'wrongish'],
                ['label' => 'Scan: ans and sign. Digit → parse whole x, ans += sign times x. ( pushes ans then sign; ) pops sign then outer', 'next' => 'stk'],
            ],
        ],
        'wrongish' => [
            'message' => "eval is banned. 227 has times and divide, no parens. 150 is already postfix. Here only plus/minus and nested parens.\nHow do parens work?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'On (: push ans, push sign, reset ans=0 sign=1. On ): ans = pop() times ans plus pop()', 'next' => 'stk'],
                ['label' => 'Read one digit at a time and never parse 10, 11, … as multi-digit', 'next' => 'wrong_digit'],
            ],
        ],
        'wrong_digit' => [
            'message' => "You are wrong here.\nNumbers can be many digits. Accumulate x = x times 10 plus the next digit.\nStep back to when you took a single character as the whole number.",
            'outcome' => 'wrong',
            'rewind_to' => 'wrongish',
            'choices' => [],
        ],
        'stk' => [
            'message' => "Last pushed is the sign, so pop sign first, then the outer ans. Spaces skip. After ( the inside starts at sign 1, so a following minus is unary.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '\"1 + 1\" → 2; \" 2-1 + 2 \" → 3; \"(1+(4+5+2)-3)+(6+8)\" → 23', 'next' => 'cpx'],
                ['label' => 'Pop the outer ans first on ), then the sign', 'next' => 'wrong_pop'],
            ],
        ],
        'wrong_pop' => [
            'message' => "You are wrong. Push order is ans then sign. LIFO: pop sign, then outer. Reversing them mixes the scale-up.\nStep back to when you popped in the wrong order.",
            'outcome' => 'wrong',
            'rewind_to' => 'stk',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(n) stack for nested parens. Plus/minus only. No eval.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stack outer ans and sign; not eval, not 227 times/divide, not one-digit numbers, not reversed pops', 'next' => 'success'],
                ['label' => 'Times and divide belong here too, with operator precedence', 'next' => 'wrong_ii'],
            ],
        ],
        'wrong_ii' => [
            'message' => "You are wrong. Times and divide are Basic Calculator II. This problem is plus, minus, and parens.\nStep back to when you added extra operators.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Running ans and sign. Push on open paren, combine on close (sign first). Parse multi-digit. O(n). Not eval, not 227, not RPN, not reversed stack pops.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
