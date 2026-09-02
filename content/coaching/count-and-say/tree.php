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
            'message' => "Problem: countAndSay(1) = \"1\". Each later term is the run-length encoding of the previous: consecutive group of c,c,c becomes count then c. n = 4 → \"1211\". 1 ≤ n ≤ 30.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count how many times each digit 0-9 appears in the previous string (a histogram)', 'next' => 'hist'],
                ['label' => 'Start from the string 1; n-1 times replace it with consecutive-run RLE', 'next' => 'rle'],
            ],
        ],
        'hist' => [
            'message' => "RLE is about consecutive groups, not totals. \"3322251\" is 2×3, then 3×2, then 1×5, then 1×1 → \"23321511\", not a global tally of every 2 and 3.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort the digits first so equal values sit together, then count', 'next' => 'wrong_sort'],
                ['label' => 'Two pointers: while s[j] == s[i], extend j; emit str(j-i) then s[i]', 'next' => 'rle'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong here.\nSorting would turn \"21\" into \"12\" and destroy the sequence. Groups must stay in the order they appear.\nStep back to when you chose how to group.",
            'outcome' => 'wrong',
            'rewind_to' => 'hist',
            'choices' => [],
        ],
        'rle' => [
            'message' => "What is the base string before the n-1 iterations?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The string 1 — countAndSay(1) is the seed; n = 1 returns it immediately', 'next' => 'example'],
                ['label' => 'Empty string — you build the first term by encoding nothing', 'next' => 'wrong_empty'],
            ],
        ],
        'wrong_empty' => [
            'message' => "You are wrong. The problem states countAndSay(1) = \"1\". Encoding an empty string is not the first term.\nStep back to when you chose the seed.",
            'outcome' => 'wrong',
            'rewind_to' => 'rle',
            'choices' => [],
        ],
        'example' => [
            'message' => "\"1\" → \"11\" → \"21\" → \"1211\". Each step: i at a run start, j walks equal chars, append the length then the digit, set i = j.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n · m) time and O(m) extra, m = length of the longest term you build', 'next' => 'success'],
                ['label' => 'O(n) because you loop n-1 times and ignore the growing string', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. Each iteration scans the whole current string. Terms get longer, so cost is n times that length.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Seed \"1\". Repeat n-1 times: two-pointer RLE of consecutive runs (count then digit). Time O(n · m), space O(m).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
