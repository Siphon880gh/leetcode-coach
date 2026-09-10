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
            'message' => "Problem: positive a (up to 2^31 − 1) and digit array b (length 1..2000, no leading zeros). Return a to the power b, mod 1337. a=2, b=[3] → 8. a=2, b=[1,0] → 1024. a=1 with a huge b → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Join b into a machine int, then call a language pow (or treat this as 50)', 'next' => 'wrong_int'],
                ['label' => 'Walk b from the last digit: consume d, then raise the base to the 10th, all mod 1337', 'next' => 'digits'],
            ],
        ],
        'wrong_int' => [
            'message' => "You are wrong here. b can be 2000 digits. Pow(x, n) (50) is a float base and a 32-bit exponent, no modulus.\nStep back to when you packed b into an int or treated this as 50.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'digits' => [
            'message' => "If b = […, d1, d0], then a^b = a^d0 times (a^10)^d1 times (a^100)^d2 and so on. Start ans = 1. From the right: multiply ans by pow(a, d, 1337), then replace a with pow(a, 10, 1337). Each pow is binary exponentiation (square the base, fold in when the exponent’s low bit is set), always mod 1337.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip the mod when raising a to 10, or never update a after the first digit', 'next' => 'wrong_mod'],
                ['label' => 'Keep both ans and a reduced mod 1337 after every digit', 'next' => 'kind'],
            ],
        ],
        'wrong_mod' => [
            'message' => "You are wrong. [1,0] needs a to become a^10 before the 1 is consumed. Overflow without the mod also breaks later digits.\nStep back to when you skipped the mod or left a stale.",
            'outcome' => 'wrong',
            'rewind_to' => 'digits',
            'choices' => [],
        ],
        'kind' => [
            'message' => "1337 is 7 times 191. Euler φ(1337)=1140 can shrink the exponent when gcd(a, 1337) is 1; the digit walk does not need that. Looping a times the numeric value of b will not finish.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'LSD digit walk, binary-exp powers, mod 1337. Not 50. Not a machine-int exponent', 'next' => 'success'],
                ['label' => 'Reduce b mod 1140 for every a, including multiples of 7 or 191', 'next' => 'wrong_euler'],
            ],
        ],
        'wrong_euler' => [
            'message' => "You are wrong. Euler’s theorem needs gcd(a, 1337)=1. If a shares a factor with 1337, reducing the exponent mod φ(1337) is invalid.\nStep back to when you used φ on every a.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. From the last digit: multiply ans by a^d, then a becomes a^10, always mod 1337. 2^[3] → 8. Not 50.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
