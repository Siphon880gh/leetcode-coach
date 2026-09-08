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
            'message' => "Problem: bash on words.txt. Lowercase letters and spaces; one or more spaces between words. Print word then count, highest count first. Ties unique. Sample: the 4, is 3, sunny 2, day 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'GROUP BY like Duplicate Emails, or a Python dict on stdin', 'next' => 'other'],
                ['label' => 'tr -s space to newline, sort, uniq -c, sort -nr, awk word then count', 'next' => 'pipe'],
            ],
        ],
        'other' => [
            'message' => "This judge wants a Unix pipe on words.txt, not SQL. A hash map is the same idea in another language; the one-liner is the pipe.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Split on a single space only, then sort alphabetically for the output', 'next' => 'wrong_split'],
                ['label' => 'Squeeze whitespace, sort so copies sit together, then uniq -c', 'next' => 'pipe'],
            ],
        ],
        'wrong_split' => [
            'message' => "You are wrong here.\nRuns of spaces must collapse. The last sort is numeric reverse by count, not A-to-Z.\nStep back to when you split on one space.",
            'outcome' => 'wrong',
            'rewind_to' => 'other',
            'choices' => [],
        ],
        'pipe' => [
            'message' => "uniq -c prints count then word. The sample is word then count: awk '{print $2, $1}'. sort -nr after uniq -c.\nWhat is the first sample line?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'the 4', 'next' => 'cpx'],
                ['label' => '4 the, or day 1 first because d comes first', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. Highest frequency first, word then count: the 4.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'pipe',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Sorting tokens is O(n log n). Extra space O(n).\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'tr -s, sort, uniq -c, sort -nr, awk swap; frequencies are unique so ties are ignored', 'next' => 'success'],
                ['label' => 'uniq -c before sort, so copies that are not adjacent still merge', 'next' => 'wrong_order'],
            ],
        ],
        'wrong_order' => [
            'message' => "You are wrong. uniq -c only collapses adjacent equal lines. sort must come first.\nStep back to when you ordered the pipe.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Squeeze spaces to newlines, sort, uniq -c, sort -nr, print word then count. Not SQL, not a single-space split. O(n log n) / O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
