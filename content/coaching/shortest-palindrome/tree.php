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
            'message' => "Problem: lowercase s, length up to 5×10⁴. Add as few characters as possible in front so the result is a palindrome. \"aacecaaa\" → \"aaacecaaa\". \"abcd\" → \"dcbabcd\". Empty or already a palindrome → s.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Append the reverse of s at the end, or brute two-pointer-check every prefix', 'next' => 'wrongish'],
                ['label' => 'Longest palindromic prefix (rolling hash vs reverse); prepend reverse of the leftover', 'next' => 'hash'],
            ],
        ],
        'wrongish' => [
            'message' => "You may only add in front, not at the end. Checking every prefix with two pointers is O(n²) and dies at 5×10⁴. Palindrome Linked List reverses the right half of a list — a different structure.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Fast/slow to the midpoint, reverse the right half, compare node values', 'next' => 'wrong_ll'],
                ['label' => 'Keep the longest prefix of s that is a palindrome; copy the leftover suffix reversed onto the front', 'next' => 'hash'],
            ],
        ],
        'wrong_ll' => [
            'message' => "You are wrong here.\nPalindrome Linked List is a list check. This is a string you pad on the left.\nStep back to when you reused the linked-list palindrome.",
            'outcome' => 'wrong',
            'rewind_to' => 'wrongish',
            'choices' => [],
        ],
        'hash' => [
            'message' => "Forward hash of s[0..i] vs reverse hash of the same slice (base 131, mod 10⁹+7). On a match, idx = i+1. Answer: reverse(s[idx:]) + s. KMP twin: s + \"#\" + reverse(s), last pi is the palindromic-prefix length.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'aacecaaa → aaacecaaa; abcd → dcbabcd', 'next' => 'cpx'],
                ['label' => 'abcd → abcddcba by adding at both ends, or aacecaaa stays unchanged', 'next' => 'wrong_samp'],
            ],
        ],
        'wrong_samp' => [
            'message' => "You are wrong. abcd needs dcb in front, not a wrap at both ends. aacecaaa still needs one extra a in front.\nStep back to when you scored the samples.",
            'outcome' => 'wrong',
            'rewind_to' => 'hash',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n). Space O(n) for the answer. Do not insert in the middle.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Pad the left with reverse leftover; rolling hash or KMP; not end-append, not O(n²), not a list reverse', 'next' => 'success'],
                ['label' => 'You may insert characters anywhere as long as the final string is a palindrome', 'next' => 'wrong_mid'],
            ],
        ],
        'wrong_mid' => [
            'message' => "You are wrong. The problem only allows adding in front of s.\nStep back to when you allowed middle inserts.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Only pad the front. Longest palindromic prefix via rolling hash (or KMP), prepend reverse of the suffix. O(n). Not appending at the end, not brute prefix checks, not Palindrome Linked List, not middle inserts.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
