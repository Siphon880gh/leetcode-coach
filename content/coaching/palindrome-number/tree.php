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
            'message' => "Problem: is x a palindrome integer? 121 → true, −121 → false, 10 → false.\nFollow-up: do it without converting to a string.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Convert to a string and two-pointer from both ends', 'next' => 'as_str'],
                ['label' => 'Reverse only the second half of the digits with % 10', 'next' => 'half'],
            ],
        ],
        'as_str' => [
            'message' => "A string check works, but the follow-up forbids it. Reversing the *whole* int also risks 32-bit overflow (see Reverse Integer).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse all of x and compare to the original', 'next' => 'wrong_full'],
                ['label' => 'Peel last digits into y until y >= remaining x, then compare halves', 'next' => 'half'],
            ],
        ],
        'wrong_full' => [
            'message' => "You are wrong here.\nA full reverse can overflow, and you do not need the first half reversed. Only rebuild the second half.\nStep back to when you chose how to reverse.",
            'outcome' => 'wrong',
            'rewind_to' => 'as_str',
            'choices' => [],
        ],
        'half' => [
            'message' => "Early false: x < 0 (the minus sign), or x != 0 and x ends in 0 (10 would read as 01).\n0 itself is a palindrome. Then y = 0; while y < x: y = y*10 + x%10; x //= 10.\nWhen do you stop?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'When y has caught up to x — you have reversed at least half the digits', 'next' => 'compare'],
                ['label' => 'When x becomes 0 — you reversed the whole number', 'next' => 'wrong_all'],
            ],
        ],
        'wrong_all' => [
            'message' => "You are wrong. Stopping at x == 0 is a full reverse again. Stop when y >= x so the two halves meet in the middle.\nStep back to when you chose the loop condition.",
            'outcome' => 'wrong',
            'rewind_to' => 'half',
            'choices' => [],
        ],
        'compare' => [
            'message' => "Even length (1221): remaining x equals y (12 and 12).\nOdd length (12321): the middle digit sits in y, so remaining x equals y // 10.\nWhat is the test?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'x == y or x == y // 10', 'next' => 'success'],
                ['label' => 'Only x == y — odd palindromes are impossible', 'next' => 'wrong_odd'],
            ],
        ],
        'wrong_odd' => [
            'message' => "You are wrong. 12321 is a palindrome. After the loop, x is 12 and y is 123, so x == y // 10.\nStep back to when you compared the halves.",
            'outcome' => 'wrong',
            'rewind_to' => 'compare',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Reject negatives and positive multiples of 10 (except 0). Reverse the second half until y >= x; accept x == y or x == y//10. Time O(log n), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
