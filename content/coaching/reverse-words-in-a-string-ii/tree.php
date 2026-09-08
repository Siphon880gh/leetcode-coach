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
            'message' => "Problem: char array s. Reverse the order of words in place. Words separated by exactly one space; no leading or trailing space. Sample: the sky is blue as chars → blue is sky the. a stays.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'split on space, reverse the word list, join — extra buffer of words', 'next' => 'split'],
                ['label' => 'Reverse the whole array, then reverse each word between spaces', 'next' => 'two'],
            ],
        ],
        'split' => [
            'message' => "That is Reverse Words (151). It uses extra space. Here you must mutate s. One full reverse would also spell each word backward.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Leave letters backward; word order is enough', 'next' => 'wrong_back'],
                ['label' => 'After reversing the buffer, reverse each word so letters face forward', 'next' => 'two'],
            ],
        ],
        'wrong_back' => [
            'message' => "You are wrong here.\neulb si yks eht is a character reverse, not reverse-words. Letters inside a word must stay in order.\nStep back to when you skipped the second reverse.",
            'outcome' => 'wrong',
            'rewind_to' => 'split',
            'choices' => [],
        ],
        'two' => [
            'message' => "Twin order: reverse each word first, then reverse the whole array. Same swaps. Two indices i, j for a reverse: O(1) extra.\nAfter reverse-all on the sky is blue, what do you reverse next?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Each slice between spaces, then the last word through the end', 'next' => 'cpx'],
                ['label' => 'Only the first word; the rest is already correct', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. Every word is spelled backward after the full reverse. You must flip each of them.\nStep back to when you reversed only one word.",
            'outcome' => 'wrong',
            'rewind_to' => 'two',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n), space O(1). Do not split or join.\nWhat is the sample after both reverses?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'blue is sky the', 'next' => 'success'],
                ['label' => 'the sky is blue unchanged, or eulb si yks eht', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. Word order flips; letters inside a word stay. Not a no-op and not a character reverse.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Reverse all, then reverse each word (or the opposite order). In-place. Not 151 split-join. Time O(n), extra O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
