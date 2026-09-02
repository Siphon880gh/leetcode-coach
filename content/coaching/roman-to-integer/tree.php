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
            'message' => "Problem: Roman to int. \"III\" → 3, \"LVIII\" → 58, \"MCMXCIV\" → 1994.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Add every symbol’s value, ignoring order', 'next' => 'sum_all'],
                ['label' => 'Map I,V,X,L,C,D,M; subtract when a value is smaller than the next', 'next' => 'scan'],
            ],
        ],
        'sum_all' => [
            'message' => "Blind sums fail: MCMXCIV would be 2216, not 1994. CM, XC, IV are subtractive.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always add — subtractive pairs are only for encoding, not decoding', 'next' => 'wrong_add'],
                ['label' => 'For each pair (a, b), if d[a] < d[b] use −d[a], else +d[a]; then add the last symbol', 'next' => 'scan'],
            ],
        ],
        'wrong_add' => [
            'message' => "You are wrong here.\nDecoding must invert subtractive form: C before M means −100, not +100.\nStep back to when you chose how to combine symbols.",
            'outcome' => 'wrong',
            'rewind_to' => 'sum_all',
            'choices' => [],
        ],
        'scan' => [
            'message' => "IV: I < V so −1, then +5 = 4. VI: V > I so +5 and +1 = 6.\nWhy look at the *next* symbol, not the previous?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A small letter is a prefix of the pair; you know to subtract before you consume the larger one', 'next' => 'example'],
                ['label' => 'Reverse the string and add left to right like Integer to Roman', 'next' => 'wrong_rev'],
            ],
        ],
        'wrong_rev' => [
            'message' => "You are wrong. You do not reverse the numeral. One left-to-right pass with a one-symbol lookahead is enough.\nStep back to when you picked the scan direction.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'example' => [
            'message' => "MCMXCIV: +1000, C < M so −100, +1000, X < C so −10, +100, I < V so −1, +5 → 1994.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(1) map of 7 letters', 'next' => 'success'],
                ['label' => 'O(n²) because each subtractive pair needs a nested search', 'next' => 'wrong_nested'],
            ],
        ],
        'wrong_nested' => [
            'message' => "You are wrong. Adjacent comparison is O(1) per index. No nested search.\nStep back to when you scored the scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Hash the seven letters. Left to right: subtract if current < next, else add; always add the last. Time O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
