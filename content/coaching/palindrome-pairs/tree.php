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
            'message' => "Problem: unique words. Return every (i, j) with i ≠ j such that words[i] plus words[j] is a palindrome. [abcd, dcba, lls, s, sssll] → [[0,1],[1,0],[3,2],[2,4]]. Empty word pairs with a palindrome. Up to 5000 words, length ≤ 300.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Concatenate every ordered pair, or treat this as palindromic substrings (5)', 'next' => 'wrong_n2'],
                ['label' => 'Hash word to index; leftover palindrome plus reverse lookup', 'next' => 'cuts'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong here. n² concatenations of length up to 600 is too slow. This is pairs of whole words, not 5 / 647 substrings.\nStep back to when you brute-forced pairs or scanned substrings.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'cuts' => [
            'message' => "For each w at i, every cut a|b: if b is a palindrome and reverse(a) is word k, emit [i, k]. If the prefix is nonempty, a is a palindrome, and reverse(b) is word k, emit [k, i]. Skip empty prefix so reverse-of-whole is not listed twice. Empty b is a palindrome, so a word and its reverse still give both orders.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Allow i == k, or skip the empty-prefix skip (duplicate reverse pairs)', 'next' => 'wrong_dup'],
                ['label' => 'O(n L²). Empty string lives in the map like any other word', 'next' => 'cpx'],
            ],
        ],
        'wrong_dup' => [
            'message' => "You are wrong. i must differ from j. The empty-prefix branch rediscovers reverse-of-whole pairs the empty-suffix case already listed.\nStep back to when you paired a word with itself or listed reverse pairs twice.",
            'outcome' => 'wrong',
            'rewind_to' => 'cuts',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "The judge wants index pairs, not the concatenated strings.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse map and leftover palindrome. Not every concat', 'next' => 'success'],
                ['label' => 'Return the concatenated palindromes instead of (i, j)', 'next' => 'wrong_str'],
            ],
        ],
        'wrong_str' => [
            'message' => "You are wrong. The return value is a list of index pairs.\nStep back to when you returned the strings.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Hash each word; leftover palindrome plus reverse lookup. Skip empty-prefix. Not every concat.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
