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
            'message' => "Problem: count strobogrammatic numbers in [low, high] (digit strings, length 1..15). \"50\"..\"100\" → 3 (69, 88, 96). \"0\"..\"0\" → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Walk every integer from low to high and run 246; or return the list like 247', 'next' => 'scan'],
                ['label' => 'For n from len(low) to len(high), generate dfs(n) from II; count those with int(s) in range', 'next' => 'len'],
            ],
        ],
        'scan' => [
            'message' => "A 15-digit span is huge; 246 per integer is impossible. 247 returns the list; this problem returns a count. Missing Number XOR-folds 0..n, a different hole.\nHow do you bound the generators?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reuse wrap 11/88/69/96 and inner 00; only endpoint lengths need numeric compare', 'next' => 'len'],
                ['label' => 'Skip \"0\" because leading zeros are forbidden', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong here.\n\"0\" is a legal number. The sample \"0\"..\"0\" answers 1.\nStep back to when you dropped zero.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'len' => [
            'message' => "Lengths strictly between len(low) and len(high) are all in range (no leading zeros). The shortest and longest batches filter with int(s) (or same-length string compare) against low and high.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '\"50\"..\"100\" → 3; \"0\"..\"0\" → 1', 'next' => 'cpx'],
                ['label' => '\"50\"..\"100\" → 4 because 8 is in the range', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. 8 has length 1, below \"50\". Only 69, 88, 96 qualify.\nStep back to when you counted 8.",
            'outcome' => 'wrong',
            'rewind_to' => 'len',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Cost is the generator’s output size, not the numeric span. Recursion O(n) plus one length’s list. Not 246-per-integer, not 247’s returned list, not Missing Number.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Generate each length with II’s dfs; count those in [low, high]', 'next' => 'success'],
                ['label' => 'Palindrome Permutation II wrap c + t + c on letters, ignore rotate pairs', 'next' => 'wrong_pal'],
            ],
        ],
        'wrong_pal' => [
            'message' => "You are wrong. That wraps the same letter for palindromes. Strobogrammatic wraps 6 with 9.\nStep back to when you reused letter palindromes.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. For each length from len(low) to len(high), generate with II’s wrap (no outer 00). Count s with int(s) between low and high. Include \"0\". Do not scan every integer.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
