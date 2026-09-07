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
            'message' => "Problem: how many trailing zeroes in n factorial. 3 → 0 (six has none). 5 → 1 (120). 0 → 0. n up to 10⁴. Follow-up: logarithmic — do not compute the factorial.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Compute n factorial then count zeros, or count the 2s, or Horner like column numbers', 'next' => 'fact'],
                ['label' => 'Count factors of 5 in 1 through n; 2s are never the bottleneck', 'next' => 'fives'],
            ],
        ],
        'fact' => [
            'message' => "n factorial for n = 10⁴ is huge. A trailing zero is a 2-and-5 pair. There are always more 2s than 5s, so counting 2s overcounts. Excel Horner is base-26 letters.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Each multiple of 5 gives one zero; ignore 25, 125, …', 'next' => 'wrong_once'],
                ['label' => 'While n is nonzero: n becomes n integer-divided by 5, add that n into ans', 'next' => 'fives'],
            ],
        ],
        'wrong_once' => [
            'message' => "You are wrong here.\n25 contributes two 5s, 125 three. A single n/5 misses the extras.\nStep back to when you counted each 5 only once.",
            'outcome' => 'wrong',
            'rewind_to' => 'fact',
            'choices' => [],
        ],
        'fives' => [
            'message' => "5: 5/5 = 1, then 1/5 = 0 → ans 1. 3: 3/5 = 0 → ans 0. 25 would add 5 + 1 because 25 is 5 squared.\nWhat is 5 factorial’s trailing-zero count?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '1', 'next' => 'ans'],
                ['label' => '0 like n = 3, or 2 as if 2 times 5 both count', 'next' => 'wrong_five'],
            ],
        ],
        'wrong_five' => [
            'message' => "You are wrong. 120 has one trailing zero. n = 3 is 0; do not add a 2-count.\nStep back to when you scored 5.",
            'outcome' => 'wrong',
            'rewind_to' => 'fives',
            'choices' => [],
        ],
        'ans' => [
            'message' => "n = 3: 3/5 = 0, no 5s, zero trailing zeroes. Time O(log n). Not Excel Horner.\nWhat is 3?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '0', 'next' => 'success'],
                ['label' => '1 from the n = 5 sample', 'next' => 'wrong_three'],
            ],
        ],
        'wrong_three' => [
            'message' => "You are wrong. 6 has no trailing zero. Do not reuse n = 5.\nStep back to when you scored 3.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sum n/5 + n/25 + n/125 until n is 0. Fives, not 2s, not the factorial. 3 → 0. 5 → 1. 0 → 0.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
