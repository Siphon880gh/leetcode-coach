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
            'message' => "Problem: true iff s and t differ by exactly one insert, delete, or replace. ab vs acb → true. empty vs empty → false. This is not min Levenshtein (Edit Distance).\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Full DP table like Edit Distance, or true when the strings are equal', 'next' => 'dp'],
                ['label' => 'Swap so s is longer, reject |m-n| > 1, then handle the first mismatch', 'next' => 'len'],
            ],
        ],
        'dp' => [
            'message' => "Edit Distance asks for the min count. Here we only need exactly one. Equal strings are zero edits, so false.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return true whenever DP would give 0 or 1', 'next' => 'wrong_zero'],
                ['label' => 'If m-n > 1, false. Else scan t; on mismatch compare the right suffixes', 'next' => 'len'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong here.\nZero edits is not one edit. empty vs empty must be false.\nStep back to when you treated equal strings as a hit.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'len' => [
            'message' => "Assume m >= n. Walk i over t. If s[i] != t[i]: replace when m == n (s[i+1:] == t[i+1:]); else delete from s (s[i+1:] == t[i:]). If the loop finishes, return m == n + 1 (the extra char is at the end of s).\nFor ab vs acb after the swap, s is acb. What happens at the first mismatch?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 's[1] is c vs t[1] is b; m != n so compare s[2:] with t[1:] — b vs b, true', 'next' => 'ans'],
                ['label' => 'Treat it as a replace because the letters differ, ignore the extra length', 'next' => 'wrong_rep'],
            ],
        ],
        'wrong_rep' => [
            'message' => "You are wrong. Lengths 3 and 2 mean insert or delete, not replace. Replace needs equal lengths.\nStep back to when the first letters disagreed.",
            'outcome' => 'wrong',
            'rewind_to' => 'len',
            'choices' => [],
        ],
        'ans' => [
            'message' => "Time O(m). empty vs empty: no mismatch, m == n+1 is false. Not Intersection of lists, not Edit Distance DP.\nWhat is empty vs empty?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'false — zero edits is not one', 'next' => 'success'],
                ['label' => 'true like ab vs acb, or the Levenshtein distance 0', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. Identical empties are false. Do not reuse the insert sample.\nStep back to when you scored the empty pair.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Longer string first, gap at most 1, first mismatch then suffixes, or leftover last char. Not Edit Distance, not equal strings, not list intersection. ab vs acb → true. empty vs empty → false.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
