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
            'message' => "Problem: after lowercasing and dropping non-alphanumeric chars, does s read the same both ways? \"A man, a plan, a canal: Panama\" → true. \"race a car\" → false. \" \" → true. n up to 2e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Palindrome Number’s reverse-the-integer, or reverse s including commas and case', 'next' => 'raw'],
                ['label' => 'Two pointers: skip non-alnum, compare lowercase, then step both', 'next' => 'scan'],
            ],
        ],
        'raw' => [
            'message' => "Palindrome Number is about digits of an int. Reversing the raw string makes \"A man...\" fail because of spaces, commas, and 'A' vs 'a'.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Valid Palindrome II (allow one delete) or Max Path Sum’s tree bend', 'next' => 'wrong_other'],
                ['label' => 'i, j = 0, n-1; while i < j: skip junk, else if lower differs return false, else i++, j--', 'next' => 'scan'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nII lets you delete one character. Max Path Sum is a tree. This is a boolean on one string with skips.\nStep back to when you copied those problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'raw',
            'choices' => [],
        ],
        'scan' => [
            'message' => "Time O(n), extra space O(1). Skip with isalnum on each side independently (if-elif), then compare.\nWhy is a string of only spaces true?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'After skips, i >= j; an empty alphanumeric string is a palindrome', 'next' => 'ret'],
                ['label' => 'Empty should be false, like Path Sum on an empty tree', 'next' => 'wrong_empty'],
            ],
        ],
        'wrong_empty' => [
            'message' => "You are wrong. The statement says an empty cleaned string is a palindrome. Path Sum’s empty-tree false does not apply.\nStep back to when you treated spaces as false.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return a boolean. End of the loop → true.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'true, false, true on the three samples — not the cleaned string amanaplanacanalpanama', 'next' => 'success'],
                ['label' => 'The filtered string, so the caller can check it', 'next' => 'wrong_str'],
            ],
        ],
        'wrong_str' => [
            'message' => "You are wrong. The judge wants true or false, not the stripped phrase.\nStep back to when you returned a string.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Two pointers, skip non-alnum, compare lowercase. O(n) / O(1). Empty cleaned string is true. Not Palindrome Number, not Valid Palindrome II, not reversing punctuation, not Max Path Sum.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
