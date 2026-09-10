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
            'message' => "Problem: shortest index gap, but word1 may equal word2 (two distinct occurrences). Dict up to 10⁵. makes vs coding → 1. makes vs makes → 3.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always 243: two latest indices; or always a WordDistance map like 244', 'next' => 'always'],
                ['label' => 'Branch: if words differ, last i and j; if they match, min gap between consecutive hits', 'next' => 'split'],
            ],
        ],
        'always' => [
            'message' => "243 forbids equality. If you still set i and j on the same k when the words match, abs is 0 — that is one occurrence, not two. 244 is many queries; this is one scan.\nWhat is the equal-word walk?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep previous hit j of that word; on a new i, ans = min(ans, i − j), then j = i', 'next' => 'split'],
                ['label' => 'Return 0 when word1 equals word2', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong here.\nThe two makes are distinct positions; the sample answer is 3, not 0.\nStep back to when you returned zero.",
            'outcome' => 'wrong',
            'rewind_to' => 'always',
            'choices' => [],
        ],
        'split' => [
            'message' => "Unequal: i = j = −1; overwrite the matching side; min abs once both exist. Equal: consecutive hits on the hit list are the closest pair of the same word.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'makes vs coding → 1; makes vs makes → 3', 'next' => 'cpx'],
                ['label' => 'makes vs makes → 1 because makes is next to coding', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. The two makes sit at indices 1 and 4; coding is a different word. Gap is 3.\nStep back to when you scored the same-word sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'split',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n), space O(1). Not distance 0 on equality, not 244’s class, not 243 blindly when the words match.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Split on equality; consecutive hits when same; 243 walk when different', 'next' => 'success'],
                ['label' => 'Paint House II rolling k colors, ignore the dictionary', 'next' => 'wrong_paint'],
            ],
        ],
        'wrong_paint' => [
            'message' => "You are wrong. Paint House II is a DP on colors. This walk is index gaps in a word list.\nStep back to when you reused the paint DP.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. If the words differ, last indices and min abs. If they match, min consecutive-hit gap. Never assign both pointers to the same k. One scan.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
