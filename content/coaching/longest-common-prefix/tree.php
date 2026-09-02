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
            'message' => "Problem: longest common prefix. [\"flower\",\"flow\",\"flight\"] → \"fl\". [\"dog\",\"racecar\",\"car\"] → \"\".\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Glue every string together, then take a prefix of that blob', 'next' => 'concat'],
                ['label' => 'Treat strs[0] as the candidate; walk column i across the other strings', 'next' => 'vertical'],
            ],
        ],
        'concat' => [
            'message' => "flowerflowflight is not a prefix of any input string. Concatenation invents characters that never sat at the same index.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort the array and return the first string — sorting already aligned the prefix', 'next' => 'wrong_sort'],
                ['label' => 'Compare character i of strs[0] to character i of every other string; stop on mismatch or a shorter word', 'next' => 'vertical'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong here.\nSorting can help a two-string trick (first vs last), but returning the first string after sort is not the LCP.\nStep back to when you chose how to compare strings.",
            'outcome' => 'wrong',
            'rewind_to' => 'concat',
            'choices' => [],
        ],
        'vertical' => [
            'message' => "At index i of strs[0], you look at every later string s.\nWhen do you return strs[0][0..i)?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'When len(s) <= i, or s[i] != strs[0][i]', 'next' => 'example'],
                ['label' => 'Only when two full strings hash differently — length never matters', 'next' => 'wrong_len'],
            ],
        ],
        'wrong_len' => [
            'message' => "You are wrong. An empty string or a shorter word cuts the prefix immediately. You must check length before s[i].\nStep back to when you defined the stop condition.",
            'outcome' => 'wrong',
            'rewind_to' => 'vertical',
            'choices' => [],
        ],
        'example' => [
            'message' => "flower / flow / flight: i=0 all f, i=1 all l, i=2 w vs i — return \"fl\". If the loop finishes, return all of strs[0].\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n × m) time, O(1) extra space — n strings, m = length of the shortest prefix scan', 'next' => 'success'],
                ['label' => 'O(n²) because every pair of strings must be fully compared', 'next' => 'wrong_pairs'],
            ],
        ],
        'wrong_pairs' => [
            'message' => "You are wrong. Vertical scan compares each character at most once per string. No all-pairs of full strings.\nStep back to when you scored the scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Benchmark strs[0]. For each index i, if any other string is too short or differs at i, return the prefix of length i. Time O(n × m), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
