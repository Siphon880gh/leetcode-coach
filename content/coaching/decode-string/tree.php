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
            'message' => "Problem: s is a valid encoding of lowercase letters, digits, and []. k[chunk] means repeat chunk k times; brackets nest. k is 1..300 and may be more than one digit. Output length stays under 1e5. 3[a]2[bc] → aaabcbc. 3[a2[c]] → accaccacc. 2[abc]3[cd]ef → abcabccdcdcdef.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat this as UTF-8 Validation (393), or as a calculator of + and ×', 'next' => 'wrong_393'],
                ['label' => 'Walk left to right with a count stack and a string stack', 'next' => 'stacks'],
            ],
        ],
        'wrong_393' => [
            'message' => "You are wrong here. 393 checks UTF-8 byte templates. A calculator parses + and ×, not k[chunk]. This string is always valid; you decode brackets.\nStep back to when you used 393 or a calculator.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'stacks' => [
            'message' => "Keep num (the digits of k being built) and res (the current chunk). Digit: multiply num by 10 then add that digit. On [: push num and res, then reset both so the inner chunk starts empty. On ]: pop the outer prefix and k, then set res to prefix plus the inner piece repeated k times. Letter: append to res.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'On ] only keep the inner repeat and drop the outer prefix that was pushed', 'next' => 'wrong_prefix'],
                ['label' => 'On ] restore the outer prefix, then append inner repeated k times', 'next' => 'kind'],
            ],
        ],
        'wrong_prefix' => [
            'message' => "You are wrong. 3[a2[c]] must become accaccacc: after decoding 2[c] you still have the outer a and the outer 3 waiting on the stacks. Dropping the prefix would lose a.\nStep back to when you dropped the outer prefix.",
            'outcome' => 'wrong',
            'rewind_to' => 'stacks',
            'choices' => [],
        ],
        'kind' => [
            'message' => "k can be 12, so digits accumulate (multiply by 10). There is no 2[4]: digits are only for k. Recursion that decodes from an index also works; the two stacks are the same nested walk without a call stack.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Two stacks. 3[a]2[bc] → aaabcbc. Not 393', 'next' => 'success'],
                ['label' => 'Treat each digit as its own k, or decode 3a without brackets', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. Consecutive digits are one integer k. Input never looks like 3a; digits always belong to a following [chunk].\nStep back to when you split a multi-digit k or decoded without brackets.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Two stacks for k[chunk]. 3[a]2[bc] → aaabcbc. 3[a2[c]] → accaccacc. Not 393.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
