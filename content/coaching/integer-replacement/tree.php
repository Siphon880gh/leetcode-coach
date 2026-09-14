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
            'message' => "Problem: n is 1 to 2^31−1. Even: replace with n/2. Odd: replace with n+1 or n−1. Return the fewest operations to reach 1. 8 → 3 (8→4→2→1). 7 → 4. 4 → 2.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat this as Collatz (always 3n+1), or BFS every integer up to 2^31', 'next' => 'wrong_collatz'],
                ['label' => 'Greedy bit rule: even always halves; odd chooses +1 or −1 from the last bits', 'next' => 'bits'],
            ],
        ],
        'wrong_collatz' => [
            'message' => "You are wrong here. Collatz always does 3n+1 on odd. Here you only add or subtract 1. Scanning the whole 2^31 range is too slow; a greedy walk is O(log n).\nStep back to when you used Collatz or a huge BFS.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'bits' => [
            'message' => "If n is even, shift right (halve). If n is odd: when n is not 3 and the last two bits are 11 (n bitwise-and 3 equals 3), add 1 so two trailing 1s become a carry that halves twice. Otherwise subtract 1. Count every replacement.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Increment 3 as well (3→4→2→1), or always pick +1 on every odd', 'next' => 'wrong_three'],
                ['label' => '3 is the exception: decrement. Other 11 endings increment', 'next' => 'kind'],
            ],
        ],
        'wrong_three' => [
            'message' => "You are wrong. 3→2→1 is two steps. 3→4→2→1 is three. Always +1 on odd would also miss 7→6→3→2→1 as a valid 4-step path, but the 11-rule still wants 7→8 because 7 ends in 11 and is not 3.\nStep back to when you incremented 3 or ignored the last two bits.",
            'outcome' => 'wrong',
            'rewind_to' => 'bits',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Memoized recursion also works. In 32-bit languages n+1 can overflow 2^31−1 — use a wider type or unsigned shift. n=1 is already 0 operations.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Even halves; odd 11 (except 3) goes up. 8 → 3. Not Collatz', 'next' => 'success'],
                ['label' => 'Stop at n=0, or divide by 3 when n is divisible by 3', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. The target is 1, and the only even move is divide by 2. There is no divide-by-3 operation.\nStep back to when you aimed at 0 or divided by 3.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Even halves. Odd: +1 when last two bits are 11 and n is not 3; else −1. 8 → 3. 7 → 4. Not Collatz.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
