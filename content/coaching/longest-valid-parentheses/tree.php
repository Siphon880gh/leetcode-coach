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
            'message' => "Problem: length of the longest well-formed parentheses substring. \"(()\" → 2. \")()())\" → 4 (the \"()()\"). \"\" → 0. Only ( and ). n up to 3·10^4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count how many () pairs exist anywhere, then return 2 × that count', 'next' => 'count'],
                ['label' => 'Stack of indices (start with -1); on a closer, pop and read i minus the new top', 'next' => 'stack'],
            ],
        ],
        'count' => [
            'message' => "\")()())\" has three matching pairs if you count globally, but they are not one substring — the answer is 4, not 6. You need a contiguous span.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A running balance (opens minus closes) at the end is the longest length', 'next' => 'wrong_bal'],
                ['label' => 'Keep unmatched positions on a stack so a pop tells you where the current valid run started', 'next' => 'stack'],
            ],
        ],
        'wrong_bal' => [
            'message' => "You are wrong here.\nBalance 0 at the end only says the whole string could be valid. \")(\" ends at 0 and the longest substring is still 0.\nStep back to when you chose how to measure a span.",
            'outcome' => 'wrong',
            'rewind_to' => 'count',
            'choices' => [],
        ],
        'stack' => [
            'message' => "Initialize stack = [-1]. Push i on '('. On ')': pop, then if the stack is empty push i as a new base, else ans = max(ans, i - stack[-1]).\nWhy the -1 sentinel?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A match that begins at index 0 needs a fake previous index so length is i - (-1)', 'next' => 'example'],
                ['label' => 'Skip the sentinel; an empty stack after pop just means length 0 for that closer', 'next' => 'wrong_sent'],
            ],
        ],
        'wrong_sent' => [
            'message' => "You are wrong. For \"()\" you push 0, then at i=1 you pop and the stack is empty. Without -1 you cannot compute length 2. The sentinel is the base of the current valid run.\nStep back to when you initialized the stack.",
            'outcome' => 'wrong',
            'rewind_to' => 'stack',
            'choices' => [],
        ],
        'example' => [
            'message' => "\")()())\": base -1; ')' empties and pushes 0; \"()()\" then yields lengths 2 and 4; last ')' pops and pushes 5. ans = 4. Ending '('s stay on the stack and never grow ans.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(n) space', 'next' => 'success'],
                ['label' => 'O(n²) because each closer rescan the prefix to find its opener', 'next' => 'wrong_n2'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong. Each index is pushed and popped at most once. No prefix rescan.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Stack of indices with sentinel -1. Push opens. On a close, pop; empty → push i as new base, else update ans with i minus the top. Time O(n), space O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
