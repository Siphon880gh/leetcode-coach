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
            'message' => "Problem: valid parentheses. \"()\" and \"()[]{}\" and \"([])\" are true. \"(]\" and \"([)]\" are false. Only ()[]{}.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count each opener and closer; equal counts mean valid', 'next' => 'count'],
                ['label' => 'Push openers; on a closer, pop and require the matching type', 'next' => 'stack'],
            ],
        ],
        'count' => [
            'message' => "\"([)]\" has one of each pair, but the closer ) does not match the latest opener [. Order matters.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Scan left to right and right to left; if both counts match, accept', 'next' => 'wrong_scan'],
                ['label' => 'A stack stores unmatched openers so the next closer must pair with the top', 'next' => 'stack'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong here.\nTwo linear counts still ignore nesting. You need last-in, first-out matching.\nStep back to when you chose how to remember openers.",
            'outcome' => 'wrong',
            'rewind_to' => 'count',
            'choices' => [],
        ],
        'stack' => [
            'message' => "For c in s: if c is ( [ or {, push it. Else pop; the popped opener plus c must be a pair in {(), [], {}}. Empty stack on a closer is false.\nWhat must be true at the end?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The stack is empty — leftover openers are unmatched', 'next' => 'example'],
                ['label' => 'A leftover opener is fine if you already saw a closer of any type', 'next' => 'wrong_left'],
            ],
        ],
        'wrong_left' => [
            'message' => "You are wrong. Every opener needs its own closer. A nonempty stack at the end means false.\nStep back to when you chose the end check.",
            'outcome' => 'wrong',
            'rewind_to' => 'stack',
            'choices' => [],
        ],
        'example' => [
            'message' => "\"([])\": push (, push [, pop [ with ], pop ( with ). Stack empty → true. \"(]\": pop ( with ] is not a pair → false.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(n) space for the stack', 'next' => 'success'],
                ['label' => 'O(1) extra space because you only need three counters', 'next' => 'wrong_o1'],
            ],
        ],
        'wrong_o1' => [
            'message' => "You are wrong. Nesting depth can be n, so the stack can hold n openers.\nStep back to when you scored the scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Push ( [ {. On a closer, the stack must be nonempty and pop + closer must be a pair. Return whether the stack is empty. Time O(n), space O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
