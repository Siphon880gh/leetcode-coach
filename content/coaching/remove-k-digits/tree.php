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
            'message' => "Problem: digit string num, length n is 1 to 1e5, k in 1..n. Return the smallest integer you can get by deleting exactly k digits (order of leftover digits stays). No leading zeros in the answer except 0 itself. 1432219, k=3 → 1219. 10200, k=1 → 200. 10, k=2 → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat this as Remove Duplicate Letters (316), or drop the k largest digits anywhere', 'next' => 'wrong_316'],
                ['label' => 'Monotonic increasing stack: pop a left peak when a smaller digit arrives', 'next' => 'stk'],
            ],
        ],
        'wrong_316' => [
            'message' => "You are wrong here. 316 keeps unique letters in greedy order. Deleting the globally largest digits can break place value: in 1432219 you drop 4, then 3, then 2 (the peak before 1), not the two 2s and 9 as an unordered set.\nStep back to when you used 316 or deleted by value not position.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'stk' => [
            'message' => "For each digit c: while k is still positive and the stack top is greater than c, pop (that peak is a leftover that would make a larger number) and decrement k. Then push c. After the scan, if k remains, chop the last k digits (the number was nondecreasing). Keep only the first n−k characters, strip leading zeros, or return 0 if nothing is left.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep leading zeros in the answer, or return empty when every digit is gone', 'next' => 'wrong_zero'],
                ['label' => 'Strip leading zeros. Empty leftover is 0. Remainder is n minus k digits', 'next' => 'kind'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. 10200 with k=1 must be 200, not 0200. Removing both digits of 10 must be 0, not an empty string.\nStep back to when you left leading zeros or returned empty.",
            'outcome' => 'wrong',
            'rewind_to' => 'stk',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Create Maximum Number (321) picks digits to maximize, the opposite greedy. n is 1e5 so do not try every k-subset.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Drop left peaks with a stack. 1432219, k=3 → 1219. Not 316', 'next' => 'success'],
                ['label' => 'Rearrange leftover digits, or delete from the right first on every input', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. Relative order is fixed. You only chop the tail when no more peaks remain. 1432219 is not solved by deleting the last three digits (219).\nStep back to when you sorted digits or always trimmed the suffix.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Monotonic stack drops left peaks. Keep n−k digits, strip zeros. 1432219, k=3 → 1219. 10, k=2 → 0. Not 316.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
