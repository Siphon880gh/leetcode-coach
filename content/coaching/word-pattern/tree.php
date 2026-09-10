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
            'message' => "Problem: does s follow pattern? Bijection: each letter maps to one word, each word to one letter. Split s on spaces. abba / dog cat cat dog → true. abba / dog cat cat fish → false. aaaa / dog cat cat dog → false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'One map letter → word only; skip the length check', 'next' => 'wrong_one'],
                ['label' => 'Split; if lengths differ, false. Two maps both ways', 'next' => 'two'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong here.\nOne map lets a and b both claim dog (abba / dog dog dog dog). A short pattern zipped against leftover words can look true.\nStep back to when you used one map or skipped the length check.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'two' => [
            'message' => "ws = s.split(). If len(pattern) != len(ws), false. d1 letter → word, d2 word → letter. For each a, b: if d1[a] exists and is not b, false; if d2[b] exists and is not a, false; else store both.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Search every split of s with no spaces (Word Pattern II)', 'next' => 'wrong_ii'],
                ['label' => 'O(m + n) time and space. Finish with no clash → true', 'next' => 'cpx'],
            ],
        ],
        'wrong_ii' => [
            'message' => "You are wrong. Here words are already split by single spaces. Word Pattern II is a different search.\nStep back to when you treated this as Pattern II.",
            'outcome' => 'wrong',
            'rewind_to' => 'two',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Isomorphic Strings is letter-to-letter. This is letter-to-word. Pattern need not equal the words.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Two maps, length check first. Not one map, not Pattern II', 'next' => 'success'],
                ['label' => 'aaaa / dog cat cat dog is true because four letters can share two words', 'next' => 'wrong_aaaa'],
            ],
        ],
        'wrong_aaaa' => [
            'message' => "You are wrong. aaaa needs one word four times. dog cat cat dog uses two words, so false.\nStep back to when you scored aaaa.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Split, match lengths, bijection both ways. abba / dog cat cat dog true. One map is not enough. Not Word Pattern II.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
