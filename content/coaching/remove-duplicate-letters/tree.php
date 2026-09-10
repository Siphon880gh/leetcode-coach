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
            'message' => "Problem: drop duplicate letters so each letter appears once, and among those subsequences pick the lexicographically smallest. \"bcabc\" → \"abc\". \"cbacdcbc\" → \"acdb\" (not \"abcd\"). Length up to 1e4; lowercase only. Same as 1081.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort unique letters, or keep the first occurrence of each letter', 'next' => 'wrong_sort'],
                ['label' => 'Greedy stack: last[c], skip if in stack, pop a larger top if it appears later', 'next' => 'stack'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong here.\nSorting unique letters ignores subsequence order (\"cbacdcbc\" is not \"abcd\"). Keeping first occurrences on \"bcabc\" yields \"bca\", not \"abc\".\nStep back to when you sorted or froze the first copy.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'stack' => [
            'message' => "Record last[c] = last index of c. Walk i, letter c. If c is already in the stack, skip. Else while the stack is non-empty, the top is > c, and last[top] > i, pop the top (it will appear again). Then push c. Join the stack.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Pop a letter on its last occurrence, or push c even when it is already in the stack', 'next' => 'wrong_pop'],
                ['label' => 'O(n). Each letter enters and leaves the stack at most once', 'next' => 'cpx'],
            ],
        ],
        'wrong_pop' => [
            'message' => "You are wrong. If last[top] is this index, popping it drops that letter forever. If c is already in the stack, a better earlier slot already won.\nStep back to when you popped a last copy or duplicated a letter.",
            'outcome' => 'wrong',
            'rewind_to' => 'stack',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "402 Remove K Digits also pops a larger top, but it has a remaining-count budget. Here the budget is “this letter still appears later.” Not a set of unique chars sorted.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Monotonic stack, pop if last[top] > i. Same as 1081. Not sorted unique', 'next' => 'success'],
                ['label' => 'Return the letters in the order they last appear in s', 'next' => 'wrong_last'],
            ],
        ],
        'wrong_last' => [
            'message' => "You are wrong. Last indices only tell you when a letter can still be popped. The answer is the greedy stack, not the last-occurrence order.\nStep back to when you emitted last-seen order.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. last[c], skip if already in the stack, pop a larger top only if it appears later, then push. O(n). Same as 1081.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
