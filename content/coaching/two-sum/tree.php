<?php
declare(strict_types=1);

/**
 * Coaching tree contract:
 * - start: node id
 * - nodes[id]: message, outcome (continue|wrong|success), choices[{label, next}], optional rewind_to on wrong
 */
return [
    'start' => 'start',
    'nodes' => [
        'start' => [
            'message' => "Problem: nums = [2, 7, 11, 15], target = 9.\nYou need the indices of two numbers that add to 9.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Check every pair (nested loops)', 'next' => 'brute'],
                ['label' => 'Scan once and remember values I have seen', 'next' => 'hash_idea'],
            ],
        ],
        'brute' => [
            'message' => "Nested loops work, but the time cost is O(n²).\nFor interviews you usually want better. What is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort then two pointers only — always enough', 'next' => 'wrong_sort'],
                ['label' => 'For each value x, ask whether target − x appeared earlier', 'next' => 'hash_idea'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong here.\nSorting + two pointers can find values, but it shuffles indices unless you track them carefully — and this problem asks for original indices. The clean path is a hash map of value → index.",
            'outcome' => 'wrong',
            'rewind_to' => 'brute',
            'choices' => [],
        ],
        'hash_idea' => [
            'message' => "Good. You walk left to right. At index i with value x, let need = target − x.\nWhere do you look for need?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'In a hash map of values seen so far', 'next' => 'map_ops'],
                ['label' => 'Only in the unsorted remainder of the array with another loop', 'next' => 'wrong_second_loop'],
            ],
        ],
        'wrong_second_loop' => [
            'message' => "You are wrong — that is still O(n²).\nStep back to when you chose how to look up the complement: use a map built during the same pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'hash_idea',
            'choices' => [],
        ],
        'map_ops' => [
            'message' => "At i = 0, x = 2, need = 7. Map is empty, so you store 2 → 0.\nAt i = 1, x = 7, need = 2. What happens?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '2 is in the map → return [0, 1]', 'next' => 'success'],
                ['label' => 'Overwrite and keep scanning forever', 'next' => 'wrong_ignore'],
            ],
        ],
        'wrong_ignore' => [
            'message' => "You are wrong. As soon as need is found in the map, you return the stored index and the current index.\nStep back to when you decided what to do on a map hit.",
            'outcome' => 'wrong',
            'rewind_to' => 'map_ops',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One pass, hash map lookups: O(n) time, O(n) space.\nYou finished this coaching path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
