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
            'message' => "Problem: true iff n equals 3 to some integer power. 27 → true. 1 → true (3^0). 0 → false. −1 → false. Follow-up: no loop, no recursion.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Power of Two bit mask (231), or log(n)/log(3) equality', 'next' => 'wrong_bit'],
                ['label' => 'Divide out 3s until n==1, or 3^19 % n == 0 with n > 0', 'next' => 'div'],
            ],
        ],
        'wrong_bit' => [
            'message' => "You are wrong here.\n231 tests a single 1-bit. Base 3 is not a power of two. Floating log equality rounds.\nStep back to when you used a bit mask or a log test.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'div' => [
            'message' => "Loop: while n > 2, if n % 3 != 0 return false, else n //= 3. Then true iff n == 1. That rejects 0 and negatives.\nNo-loop: largest 3^x in signed 32-bit is 3^19 = 1162261467. n > 0 and 1162261467 % n == 0. Guard n > 0 before the remainder (modulo 0 is undefined).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat 1 as false, or skip the n > 0 guard', 'next' => 'wrong_one'],
                ['label' => 'O(log n) loop or O(1) modulo. Space O(1)', 'next' => 'cpx'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. 3^0 is 1. Remainder by 0 is undefined, so n > 0 must come first.\nStep back to when you rejected 1 or divided by n without the guard.",
            'outcome' => 'wrong',
            'rewind_to' => 'div',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "−3 is not a power of three. 9 is. 342 is Power of Four, not this.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Divide by 3, or 3^19 modulo n. Not 231, not log', 'next' => 'success'],
                ['label' => 'Return true for every multiple of 3', 'next' => 'wrong_mult'],
            ],
        ],
        'wrong_mult' => [
            'message' => "You are wrong. 6 is divisible by 3 but is not a power of 3.\nStep back to when you accepted every multiple of 3.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Divide out 3s until 1, or 1162261467 % n == 0 with n > 0. 1 is true. 0 and negatives are false. Not 231.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
