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
            'message' => "Problem: compare two dotted version strings. Each revision is an integer (leading zeros ignored). Missing revisions are 0. Return -1, 1, or 0. 1.2 vs 1.10 → -1. 1.01 vs 1.001 → 0. 1.0 vs 1.0.0.0 → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Lexicographic string compare, float(1.10), or Maximum Gap buckets', 'next' => 'lex'],
                ['label' => 'Two pointers: parse each revision as an int; a missing side is 0', 'next' => 'ptr'],
            ],
        ],
        'lex' => [
            'message' => "String order would treat 10 as coming before 2. float(\"1.10\") equals 1.1 and drops later revisions. Maximum Gap is array buckets.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Compare the raw digit strings including leading zeros', 'next' => 'wrong_str'],
                ['label' => 'Walk both strings; accumulate a and b until a dot; compare a vs b as integers', 'next' => 'ptr'],
            ],
        ],
        'wrong_str' => [
            'message' => "You are wrong here.\n01 and 001 are both 1. Length of the token is not the value.\nStep back to when you kept the zeros.",
            'outcome' => 'wrong',
            'rewind_to' => 'lex',
            'choices' => [],
        ],
        'ptr' => [
            'message' => "while i < m or j < n: parse a until dot (or 0 if that string is done), same for b. If a != b return -1 or 1. Skip the dots. If the loops finish, 0.\nWhy is 1.2 vs 1.10 equal to -1, not 1?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Second revisions 2 vs 10 as integers; 2 < 10', 'next' => 'ans'],
                ['label' => 'The character 1 in 10 comes before 2, so version2 is smaller', 'next' => 'wrong_10'],
            ],
        ],
        'wrong_10' => [
            'message' => "You are wrong. Revisions are numbers, not digit strings. 10 is ten.\nStep back to when you ordered 2 against 10.",
            'outcome' => 'wrong',
            'rewind_to' => 'ptr',
            'choices' => [],
        ],
        'ans' => [
            'message' => "1.0 vs 1.0.0.0 keeps comparing 0 against missing 0. Time O(m+n). Not Maximum Gap, not One Edit.\nWhat is 1.01 vs 1.001?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '0 — both second revisions are 1', 'next' => 'success'],
                ['label' => '-1 like 1.2 vs 1.10, or 1 because 001 is longer', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. Leading zeros do not change the integer. Do not reuse the 1.2 sample.\nStep back to when you scored 1.01 vs 1.001.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Parse revisions as ints, pad the short side with 0. Not lexicographic, not float, not Maximum Gap. 1.2 vs 1.10 → -1. 1.01 vs 1.001 → 0. 1.0 vs 1.0.0.0 → 0.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
