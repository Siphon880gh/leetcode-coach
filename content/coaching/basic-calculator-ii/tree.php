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
            'message' => "Problem: expression of non-negative integers, plus, minus, times, divide, spaces. No parens. Divide toward zero. No eval. n up to 3 × 10⁵. \"3+2×2\" → 7. \" 3/2 \" → 1. \" 3+5 / 2 \" → 5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'eval(s), or Basic Calculator (224) paren stack, or RPN postfix', 'next' => 'wrongish'],
                ['label' => 'Scan numbers; previous operator: plus/minus push signed v; times/divide replace the stack top', 'next' => 'stk'],
            ],
        ],
        'wrongish' => [
            'message' => "eval is banned. 224 has parens and only plus/minus. 150 is already postfix. Here times and divide bind tighter, with no grouping.\nHow does the previous operator join v?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hold sign (start plus) and v. At an operator or the last char, apply that previous sign, then sign becomes this operator', 'next' => 'stk'],
                ['label' => 'Apply the operator you just read to the number you just finished', 'next' => 'wrong_now'],
            ],
        ],
        'wrong_now' => [
            'message' => "You are wrong here.\nThe operator you just saw belongs to the next number. The previous sign decides how this v joins the stack.\nStep back to when you applied the new operator too early.",
            'outcome' => 'wrong',
            'rewind_to' => 'wrongish',
            'choices' => [],
        ],
        'stk' => [
            'message' => "Plus pushes v. Minus pushes −v. Times pops and pushes pop × v. Divide pops and pushes toward-zero pop / v, then reset v. Skip spaces. Sum the stack at the end.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '\"3+2×2\" → 7; \" 3/2 \" → 1; \" 3+5 / 2 \" → 5', 'next' => 'cpx'],
                ['label' => 'Floor-divide toward negative infinity when the top is negative', 'next' => 'wrong_floor'],
            ],
        ],
        'wrong_floor' => [
            'message' => "You are wrong. The problem truncates toward zero (int(a / b) in Python, not floor).\nStep back to when you used floor divide.",
            'outcome' => 'wrong',
            'rewind_to' => 'stk',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(n) stack. Multi-digit v = v × 10 plus digit. No eval, no parens.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Previous operator on a stack; not eval, not 224 parens, not applying the new op now, not floor divide', 'next' => 'success'],
                ['label' => 'Parse parentheses the same way as Basic Calculator', 'next' => 'wrong_paren'],
            ],
        ],
        'wrong_paren' => [
            'message' => "You are wrong. This problem has no parentheses. That stack-of-ans-and-sign is 224.\nStep back to when you added parens.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Previous operator: plus/minus push signed v; times/divide fold the top now. Toward-zero divide. Sum the stack. O(n). Not eval, not 224, not applying the new operator immediately, not floor divide.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
