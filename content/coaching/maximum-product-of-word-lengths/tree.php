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
            'message' => "Problem: max length(i) × length(j) for two words that share no letter. None → 0. [\"abcw\",\"baz\",\"foo\",\"bar\",\"xtfn\",\"abcdef\"] → 16 (abcw and xtfn). [\"a\",\"ab\",\"abc\",\"d\",\"cd\",\"bcd\",\"abcd\"] → 4. [\"a\",\"aa\",\"aaa\",\"aaaa\"] → 0. Up to 1000 words, each length up to 1000, lowercase.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Set-intersect letters on every pair, or multiply unique-letter counts', 'next' => 'wrong_set'],
                ['label' => '26-bit mask per word; pair is legal iff mask AND mask is 0', 'next' => 'mask'],
            ],
        ],
        'wrong_set' => [
            'message' => "You are wrong here.\nA set intersect per pair is extra work when 26 bits already test overlap. The product uses full word lengths: \"aa\" still has length 2, not 1.\nStep back to when you scanned sets or unique-letter sizes.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'mask' => [
            'message' => "mask[i] |= 1 shifted by (c minus a). Walk i, build mask[i], then compare every j < i. If (mask[i] AND mask[j]) == 0, update ans with len(i) × len(j). Duplicate letters in one word set the same bit twice; that is fine.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat overlapping \"ab\" / \"bc\" as legal, or skip the all-overlap → 0 case', 'next' => 'wrong_overlap'],
                ['label' => 'O(n² + L). Keep the max product; start ans at 0', 'next' => 'cpx'],
            ],
        ],
        'wrong_overlap' => [
            'message' => "You are wrong. Shared letters make AND nonzero. If every pair overlaps, the answer stays 0.\nStep back to when you allowed overlap or assumed a pair always exists.",
            'outcome' => 'wrong',
            'rewind_to' => 'mask',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Solution 2 maps mask → max length so duplicate alphabets keep the longer word. Same AND test.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Bitmask AND == 0, then full lengths. Not unique-letter sizes', 'next' => 'success'],
                ['label' => 'Sort words by length and only test the two longest', 'next' => 'wrong_two'],
            ],
        ],
        'wrong_two' => [
            'message' => "You are wrong. The two longest may share letters (abcdef vs abcw). A shorter disjoint pair can win.\nStep back to when you only compared the two longest.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One bit per letter. AND == 0 means disjoint; then multiply full lengths. No pair → 0. O(n² + L).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
