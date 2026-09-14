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
            'message' => "Problem: given n from 1 to 1e4, return a 1-indexed string list of length n. For each i from 1 to n: FizzBuzz if i is divisible by 3 and 5, Fizz if only by 3, Buzz if only by 5, else the decimal of i. n=3 → 1,2,Fizz. n=15 ends with FizzBuzz.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Spawn four threads with a lock (1195), or start i at 0', 'next' => 'wrong_1195'],
                ['label' => 'One sequential walk from 1 to n. Test the joint multiple first', 'next' => 'order'],
            ],
        ],
        'wrong_1195' => [
            'message' => "You are wrong here. Fizz Buzz Multithreaded (1195) prints the same strings from four threads. This problem is one sequential walk. Starting at 0 emits a bogus 0 and shifts every later slot.\nStep back to when you chose 1195 or a 0-based loop.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'order' => [
            'message' => "For each i you must emit a string. If you test i % 3 == 0 first and return Fizz, then 15 never becomes FizzBuzz. Concatenating Fizz then Buzz when each factor hits is the same joint case.\nWhich check order?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Test 3 first and return Fizz, so 15 stays Fizz', 'next' => 'wrong_3'],
                ['label' => 'Test i % 15 == 0 (or both factors) before the single-factor tests', 'next' => 'kind'],
            ],
        ],
        'wrong_3' => [
            'message' => "You are wrong. The joint case is listed first in the statement. Check 15 (or 3 and 5 together) before 3 or 5 alone.\nStep back to when you returned Fizz for a multiple of 15.",
            'outcome' => 'wrong',
            'rewind_to' => 'order',
            'choices' => [],
        ],
        'kind' => [
            'message' => "n=5 → 1,2,Fizz,4,Buzz. The statement talks about answer[i] as value i, but you still append from 1 in order. Return strings, not integers.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Walk 1..n. 15 first, then 3, then 5, else str(i). Not 1195', 'next' => 'success'],
                ['label' => 'Return the integers themselves when no Fizz or Buzz applies', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. The array is a list of strings. Non-Fizz/Buzz slots are the decimal of i as text.\nStep back to when you returned integers.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Walk 1..n. Test 15 before 3 or 5. n=3 → 1,2,Fizz. n=15 ends in FizzBuzz. Not 1195.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
