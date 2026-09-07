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
            'message' => "Problem: TwoSum on a stream. add(number), find(value) true iff two stored numbers (distinct uses) sum to value. add 1, 3, 5; find(4) is true; find(7) is false. At most 10^4 calls.\nWhat do you store?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Rebuild Two Sum I on a list each find, or Two Sum II two pointers on unsorted data', 'next' => 'rebuild'],
                ['label' => 'A count map: add increments cnt[number] in O(1)', 'next' => 'cnt'],
            ],
        ],
        'rebuild' => [
            'message' => "Dumping to a list and nested-looping each find is quadratic. Two Sum II needs a sorted array, not a live stream. Two Sum I is one array, one query.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'find always returns true after two adds', 'next' => 'wrong_always'],
                ['label' => 'Keep counts; find walks keys and asks for value minus x', 'next' => 'cnt'],
            ],
        ],
        'wrong_always' => [
            'message' => "You are wrong here.\nAfter 1, 3, 5, find(7) is false. Two adds do not make every target true.\nStep back to when you skipped the map.",
            'outcome' => 'wrong',
            'rewind_to' => 'rebuild',
            'choices' => [],
        ],
        'cnt' => [
            'message' => "find: for each key x, y = value − x. Need y in cnt, and if x equals y the count of x must be greater than 1.\nadd(1) once, then find(2). What happens?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'False — one 1 cannot pair with itself', 'next' => 'pair'],
                ['label' => 'True because 1+1=2, or reuse find(4) from the sample', 'next' => 'wrong_half'],
            ],
        ],
        'wrong_half' => [
            'message' => "You are wrong. A same-number pair needs two copies. One add(1) leaves count 1, so find(2) is false.\nStep back to when you scored find(2).",
            'outcome' => 'wrong',
            'rewind_to' => 'cnt',
            'choices' => [],
        ],
        'pair' => [
            'message' => "Sample again: cnt is 1, 3, 5 each once. find(4): x=1, y=3 is present and 1≠3 → true. find(7): 1+6, 3+4, 5+2, none in the map → false.\nWhat are find(4) and find(7)?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'true then false', 'next' => 'success'],
                ['label' => 'false then true, or true then true', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. 1+3 is 4 (true). Nothing makes 7 (false).\nStep back to when you scored the sample finds.",
            'outcome' => 'wrong',
            'rewind_to' => 'pair',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Count map; add O(1); find O(n) over distinct keys; same value needs count greater than 1. Not Two Sum I’s one-shot array, not Two Sum II’s sorted pointers. find(4) true, find(7) false.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
