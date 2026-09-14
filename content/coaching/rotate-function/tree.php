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
            'message' => "Problem: nums length n is 1 to 1e5, values −100..100. After a clockwise rotate by k, F(k) is 0 times arr[0] + 1 times arr[1] + … + (n−1) times arr[n−1]. Return the max of F(0)..F(n−1). [4,3,2,6] → 26. [100] → 0. Fits in 32-bit.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat this as Rotate Array (189), or rebuild every F in O(n²)', 'next' => 'wrong_189'],
                ['label' => 'Compute F(0) once, then jump to the next F with a closed form', 'next' => 'rec'],
            ],
        ],
        'wrong_189' => [
            'message' => "You are wrong here. 189 only rotates the array. Rebuilding each F costs O(n²) and n is 1e5. You need a one-step update from F(k) to F(k+1).\nStep back to when you used 189 or rebuilt every F.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'rec' => [
            'message' => "Clockwise rotate moves the last cell to index 0. Every other weight goes up by 1, so you add the total sum, then subtract n times the value that just landed at index 0 (it lost weight n−1 and now has weight 0). In code: F += sum − n times nums[n−i] while i walks 1..n−1. Track the max, starting from F(0).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Add n times the wrapping value, or forget to seed the max with F(0)', 'next' => 'wrong_sign'],
                ['label' => 'Next F = last F + sum − n times the new head. Keep a running max', 'next' => 'kind'],
            ],
        ],
        'wrong_sign' => [
            'message' => "You are wrong. The wrap-around value drops from weight n−1 to 0, so you subtract n times that value after adding the sum. F(0) for [4,3,2,6] is 25 and is a candidate; the max 26 is F(3).\nStep back to when you flipped the sign or skipped F(0).",
            'outcome' => 'wrong',
            'rewind_to' => 'rec',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Single-element [100] is 0 because the only weight is 0. Values can be negative. One O(n) pass after F(0) is enough.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Recurrence on F. [4,3,2,6] → 26. Not 189', 'next' => 'success'],
                ['label' => 'Rotate counterclockwise, or weight from n−1 down to 0 as the definition', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. The problem rotates clock-wise, and F uses weights 0, 1, …, n−1 from left to right on the rotated array.\nStep back to when you reversed the rotate direction or the weights.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Next F = last F + sum − n times the new head. [4,3,2,6] → 26. [100] → 0. Not 189.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
