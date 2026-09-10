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
            'message' => "Problem: true if t is a rearrangement of s (same letters, same counts). Lowercase English, length up to 5 × 10⁴. \"anagram\" / \"nagaram\" → true. \"rat\" / \"car\" → false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Group Anagrams: bucket many words, or return true when s equals t', 'next' => 'group'],
                ['label' => 'If lengths differ, false. Count letters in s; decrement on t; reject a negative', 'next' => 'count'],
            ],
        ],
        'group' => [
            'message' => "Group Anagrams (49) clusters a list of words. s == t is identity, not an anagram test. Ransom Note asks whether counts of t cover s as a subset, not equality.\nWhat is the two-string test?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count 26 on s, decrement t, fail below 0; or sort both strings and compare', 'next' => 'count'],
                ['label' => 'Treat \"ab\" and \"aab\" as anagrams because every letter of ab appears in aab', 'next' => 'wrong_subset'],
            ],
        ],
        'wrong_subset' => [
            'message' => "You are wrong here.\nAnagrams need equal multiplicities. Lengths 2 and 3 already fail; extra a is leftover.\nStep back to when you used a subset check.",
            'outcome' => 'wrong',
            'rewind_to' => 'group',
            'choices' => [],
        ],
        'count' => [
            'message' => "Length check first (O(1) reject). Array of 26 or a map: increment s, then for each char in t decrement; if a count goes below 0, false. Lengths equal means leftovers cannot hide. Sorting both and comparing is correct but O(n log n).\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '\"anagram\" / \"nagaram\" true; \"rat\" / \"car\" false', 'next' => 'cpx'],
                ['label' => 'Skip the length check; scan t only and ignore leftover letters in s', 'next' => 'wrong_len'],
            ],
        ],
        'wrong_len' => [
            'message' => "You are wrong. If t is a prefix of a longer s, decrement never goes negative, but leftover letters remain. Equal length (or a final all-zero check) is required.\nStep back to when you skipped the length test.",
            'outcome' => 'wrong',
            'rewind_to' => 'count',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n) counting, O(n log n) sort. Space O(1) for 26 letters. Unicode follow-up: a hash map of code points instead of size 26. Not Group Anagrams lists, not s == t, not a subset.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Equal length, count then decrement (or sort both); not Group Anagrams, not identity', 'next' => 'success'],
                ['label' => 'Isomorphic Strings: two maps of letter-to-letter, ignore counts', 'next' => 'wrong_iso'],
            ],
        ],
        'wrong_iso' => [
            'message' => "You are wrong. Isomorphic Strings is a bijection of characters, not equal bag-of-letters. Anagrams may permute freely as long as counts match.\nStep back to when you reused the isomorphism maps.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Unequal lengths → false. Count 26 in s, decrement on t, reject a negative. Sort both is the same predicate, slower. Unicode: map code points. Not Group Anagrams, not s == t.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
