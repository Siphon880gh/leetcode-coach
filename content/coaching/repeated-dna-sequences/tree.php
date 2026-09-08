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
            'message' => "Problem: DNA string over A, C, G, T. Return every length-10 substring that appears more than once, any order. Sample: AAAAACCCCCAAAAACCCCCCAAAAAGGGTTT → AAAAACCCCC and CCCCCAAAAA. Thirteen As → AAAAAAAAAA once. Shorter than 10 → empty.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count every substring of any length, keep those with count greater than 1', 'next' => 'any'],
                ['label' => 'Slide windows of length 10; when a count first becomes 2, append it', 'next' => 'ten'],
            ],
        ],
        'any' => [
            'message' => "The problem is fixed 10-mers, not every length. Reverse Words II mutated a char array; here the unit is s[i : i+10].\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Append t every time cnt[t] is greater than 1 — thirteen As would list it many times', 'next' => 'wrong_many'],
                ['label' => 'Increment the map; append only when the count equals 2', 'next' => 'ten'],
            ],
        ],
        'wrong_many' => [
            'message' => "You are wrong here.\nCount 3 or more must stay silent so each sequence appears once. Thirteen As is one window type, one output row.\nStep back to when you appended every extra hit.",
            'outcome' => 'wrong',
            'rewind_to' => 'any',
            'choices' => [],
        ],
        'ten' => [
            'message' => "i from 0 through n − 10. Rolling-hash twin: A,C,G,T as 0..3, a 10-letter window as a base-4 integer; drop the left letter, append the new one. Same emit-at-2 rule.\nWhat does a string of length 9 return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Empty list — no 10-mer exists', 'next' => 'cpx'],
                ['label' => 'The whole string, padded or repeated', 'next' => 'wrong_short'],
            ],
        ],
        'wrong_short' => [
            'message' => "You are wrong. If n is less than 10 the loop range is empty.\nStep back to when you invented a 10-mer from a short string.",
            'outcome' => 'wrong',
            'rewind_to' => 'ten',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n) windows. Space O(n) distinct 10-mers worst case.\nSample two sequences?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'AAAAACCCCC and CCCCCAAAAA', 'next' => 'success'],
                ['label' => 'The whole 32-letter string, or every overlapping 10-mer', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. Only 10-mers that occur more than once, each listed once.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Length-10 windows, emit when the count first hits 2. Thirteen As → one row. Short strings → empty. Time O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
