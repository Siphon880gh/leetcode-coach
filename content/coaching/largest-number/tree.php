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
            'message' => "Problem: arrange non-negative nums into the largest number, as a string (it can overflow a 64-bit int). [10,2] → \"210\". [3,30,34,5,9] → \"9534330\".\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort the integers descending and join: 10 then 2 is \"102\"', 'next' => 'numeric'],
                ['label' => 'Stringify, then order so a comes first when a+b is larger than b+a', 'next' => 'concat'],
            ],
        ],
        'numeric' => [
            'message' => "Numeric descending is wrong: 10 before 2 is \"102\", but \"210\" is larger. Rank Scores ranked values; here the order of pieces is the whole answer.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Pad shorter numbers with zeros until lengths match, then sort', 'next' => 'wrong_pad'],
                ['label' => 'Compare concatenations: put a before b when a+b beats b+a', 'next' => 'concat'],
            ],
        ],
        'wrong_pad' => [
            'message' => "You are wrong here.\nPadding 3 vs 30 as 30 vs 30 cannot tell them apart. \"330\" vs \"303\" can.\nStep back to when you padded instead of concatenating.",
            'outcome' => 'wrong',
            'rewind_to' => 'numeric',
            'choices' => [],
        ],
        'concat' => [
            'message' => "3 vs 30: \"330\" beats \"303\", so 3 first. 3 vs 34: \"343\" beats \"334\", so 34 first. Python: sort with cmp_to_key so a+b < b+a means a goes later.\n[10,2]: which order?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '2 then 10 → \"210\"', 'next' => 'zeros'],
                ['label' => '10 then 2 → \"102\", because 10 is the larger integer', 'next' => 'wrong_102'],
            ],
        ],
        'wrong_102' => [
            'message' => "You are wrong. \"210\" is larger than \"102\". The comparator is concatenation, not numeric size.\nStep back to when you ordered 10 and 2.",
            'outcome' => 'wrong',
            'rewind_to' => 'concat',
            'choices' => [],
        ],
        'zeros' => [
            'message' => "Join the sorted strings. If the first piece is \"0\", every piece was zero.\nWhat do you return for [0,0]?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '\"0\" — not \"00\"', 'next' => 'success'],
                ['label' => '\"00\", or 0 as an integer', 'next' => 'wrong_00'],
            ],
        ],
        'wrong_00' => [
            'message' => "You are wrong. Leading zeros after join mean the whole answer is the string \"0\". Returning an int would overflow on other inputs.\nStep back to when you handled all zeros.",
            'outcome' => 'wrong',
            'rewind_to' => 'zeros',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Stringify, sort by a+b vs b+a, join. First piece \"0\" → \"0\". Time O(n log n · L), space O(n L). Not numeric descending, not zero-padding.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
