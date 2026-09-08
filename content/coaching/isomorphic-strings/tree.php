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
            'message' => "Problem: can you replace characters of s to get t? Same letter always maps to the same target; two letters cannot share a target; a letter may map to itself. egg/add → true. paper/title → true. f11/b23 → false. Lengths equal, ASCII, n ≤ 5 × 10⁴.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'One map s→t only, or sort both strings and compare', 'next' => 'one'],
                ['label' => 'Two maps: s→t and t→s; fail if either direction disagrees', 'next' => 'two'],
            ],
        ],
        'one' => [
            'message' => "ab / aa needs the reverse map: a and b both want a. Sorting destroys order (egg/add would scramble). Count Primes sieves integers; this is a string bijection.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Implement Stack using Queues: rotate so newest is at the front', 'next' => 'wrong_stack'],
                ['label' => 'Record both directions; f11 fails because 1 cannot map to both 2 and 3', 'next' => 'two'],
            ],
        ],
        'wrong_stack' => [
            'message' => "You are wrong here.\nThat adapter is a LIFO queue trick. This walk is a character pairing.\nStep back to when you reused the stack adapter.",
            'outcome' => 'wrong',
            'rewind_to' => 'one',
            'choices' => [],
        ],
        'two' => [
            'message' => "At each i: a=s[i], b=t[i]. If d1[a] exists and is not b, false. If d2[b] exists and is not a, false. Else store both. Array twin: last-seen index per byte (store i+1).\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'egg/add and paper/title are true; f11/b23 is false', 'next' => 'cpx'],
                ['label' => 'ab/aa is true with one map, or egg/add is false because e is not a', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. Mapping need not be identity (e→a is fine). ab/aa is false: two sources cannot share a.\nStep back to when you scored the samples.",
            'outcome' => 'wrong',
            'rewind_to' => 'two',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n). Space O(C) with C=256, or the distinct characters.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Bijection both ways; not one map, not sort, not identity-only', 'next' => 'success'],
                ['label' => 'Lengths may differ; pad the shorter string with spaces', 'next' => 'wrong_len'],
            ],
        ],
        'wrong_len' => [
            'message' => "You are wrong. The problem already guarantees equal lengths. Do not pad.\nStep back to when you changed the lengths.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Two maps (or last-seen arrays) lock a bijection. egg/add true, f11/b23 false, ab/aa false. O(n). Not one map, not sort, not a stack adapter, not Count Primes.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
