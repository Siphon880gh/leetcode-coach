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
            'message' => "Problem: group anagrams. [\"eat\",\"tea\",\"tan\",\"ate\",\"nat\",\"bat\"] → [eat/tea/ate], [tan/nat], [bat]. n ≤ 1e4, each length ≤ 100, lowercase.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'For every pair of strings, test anagram and union their groups', 'next' => 'nested'],
                ['label' => 'Map key = characters of s sorted; append s to d[key]', 'next' => 'hash'],
            ],
        ],
        'nested' => [
            'message' => "Pairwise unions are O(n² · k). With n = 1e4 that is too slow. Length-only buckets still mix eat and tan.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Key each word by the set of its letters (ignore counts)', 'next' => 'wrong_set'],
                ['label' => 'Anagrams share one sorted signature such as eat → aet; hash lists by that key', 'next' => 'hash'],
            ],
        ],
        'wrong_set' => [
            'message' => "You are wrong here.\n\"aab\" and \"abb\" have the same letter set {a,b} but are not anagrams. You need the multiset (sorted string or a 26-count tuple).\nStep back to when you chose the key.",
            'outcome' => 'wrong',
            'rewind_to' => 'nested',
            'choices' => [],
        ],
        'hash' => [
            'message' => "A 26-length count tuple is also a valid key (O(k) per word, no sort). Why still return the original strings, not the keys?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The answer lists the inputs as given (eat, tea, …), grouped; the key is only for hashing', 'next' => 'example'],
                ['label' => 'Return the sorted keys once each; the originals are redundant', 'next' => 'wrong_keys'],
            ],
        ],
        'wrong_keys' => [
            'message' => "You are wrong. The groups must contain the original words, not one canonical spelling per bucket.\nStep back to when you chose what to store.",
            'outcome' => 'wrong',
            'rewind_to' => 'hash',
            'choices' => [],
        ],
        'example' => [
            'message' => "d[\"aet\"] gets eat, tea, ate. d[\"ant\"] gets tan, nat. d[\"abt\"] gets bat. Return list(d.values()). Empty string keys as \"\".\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n · k log k) if the key is sorted; O(n · k) with a count tuple; extra O(n · k)', 'next' => 'success'],
                ['label' => 'O(n) because a hash map visit is constant regardless of string length', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. Building the key scans (and maybe sorts) each of k characters. That cost is per word.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. For each s, key = sorted(s) (or a 26-count tuple). Append the original s to d[key]. Return the map values. Time O(n · k log k) or O(n · k). Not pairwise unions and not a letter set.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
