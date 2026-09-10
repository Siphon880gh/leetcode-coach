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
            'message' => "Problem: return every palindromic permutation of s, no duplicates. Empty list if none. \"aabb\" → abba, baab. \"abc\" → []. Length ≤ 16.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Palindrome Permutation (266) yes/no, or permute all n! strings then keep palindromes', 'next' => 'perm'],
                ['label' => 'At most one odd letter; seed the center; wrap the same letter on both ends', 'next' => 'wrap'],
            ],
        ],
        'perm' => [
            'message' => "266 only asks existence. n! then a palindrome check duplicates work and explodes even at 16.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Strobogrammatic II wraps rotate-pairs; here wrap the same letter: c + t + c', 'next' => 'wrap'],
                ['label' => 'Build the left half only, then copy it without reversing onto the right', 'next' => 'wrong_copy'],
            ],
        ],
        'wrong_copy' => [
            'message' => "You are wrong here.\nThe right half is the reverse of the left. Copying without reverse is not a palindrome.\nStep back to when you skipped the reverse.",
            'outcome' => 'wrong',
            'rewind_to' => 'perm',
            'choices' => [],
        ],
        'wrap' => [
            'message' => "Count 26. Two or more odds → []. One odd: that letter is mid (consume one). Even: mid is empty. dfs: if len(t)==n keep t; else for each letter with at least 2 left, subtract 2, recurse c+t+c, add 2 back.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '"aabb" → abba and baab; "abc" → []', 'next' => 'cpx'],
                ['label' => 'Still emit palindromes for "abc" by putting b in the center and ignoring extra odds', 'next' => 'wrong_abc'],
            ],
        ],
        'wrong_abc' => [
            'message' => "You are wrong. Two odds cannot sit on one center. \"abc\" has no palindromic permutation.\nStep back to when you skipped the two-odd reject.",
            'outcome' => 'wrong',
            'rewind_to' => 'wrap',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Growing from the middle uses each pair once, so you do not list baba as a scramble of a non-palindrome.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Center from the odd letter; wrap pairs. Not 266, not n!, not skip the two-odd check', 'next' => 'success'],
                ['label' => 'Wrap a letter on the left only and hope the right matches later', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. Both ends take the same letter in one step. One-sided wrap is a normal permutation, not a palindrome builder.\nStep back to when you wrapped one side.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Two odds → []. Seed dfs with the odd letter or empty. Wrap c + t + c while a count is at least 2. \"aabb\" → abba, baab. Not 266’s boolean, not n! then filter.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
