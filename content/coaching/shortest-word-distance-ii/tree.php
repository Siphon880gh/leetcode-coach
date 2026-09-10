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
            'message' => "Problem: build WordDistance from wordsDict, then shortest(word1, word2) up to 5000 times. Distinct words, both present. Dict up to 3 × 10⁴. coding/practice → 3; makes/coding → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Each shortest: one scan of the whole dict like 243; or nest every index of A with every index of B', 'next' => 'rescan'],
                ['label' => 'Constructor: map word → all indices. Query: two pointers on those two increasing lists', 'next' => 'map'],
            ],
        ],
        'rescan' => [
            'message' => "5000 times 3 × 10⁴ is too slow. Nested p × q is also wasteful: the lists are already sorted. III allows word1 == word2; here they differ.\nWhat is the preprocess?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Append each i to map[word]. shortest: walk a and b, advance the smaller index, track min abs', 'next' => 'map'],
                ['label' => 'Store only the last index of each word, then answer in O(1)', 'next' => 'wrong_last'],
            ],
        ],
        'wrong_last' => [
            'message' => "You are wrong here.\nmakes appears twice; last-only forgets the first makes that may be closer to another word.\nStep back to when you kept a single index.",
            'outcome' => 'wrong',
            'rewind_to' => 'rescan',
            'choices' => [],
        ],
        'map' => [
            'message' => "Lists are increasing because you appended in scan order. Two pointers: ans = min(ans, abs(a[i] − b[j])); if a[i] ≤ b[j] then i++, else j++. The lagging word’s next chance is the current other index.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'coding vs practice → 3; makes vs coding → 1', 'next' => 'cpx'],
                ['label' => 'Assume each word appears once, so shortest is always abs of two stored ints', 'next' => 'wrong_once'],
            ],
        ],
        'wrong_once' => [
            'message' => "You are wrong. makes has two indices. You must keep the full list, not one slot per word.\nStep back to when you assumed unique words.",
            'outcome' => 'wrong',
            'rewind_to' => 'map',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Construct O(n). Each shortest O(p + q). Space O(n). Not 243 per call, not nested pairs, not last-index-only, not III’s same-word scan.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Index lists plus two-pointer merge; not a full rescan, not last-only', 'next' => 'success'],
                ['label' => 'Ugly Number II three pointers on ×2 ×3 ×5, ignore the dictionary', 'next' => 'wrong_ugly'],
            ],
        ],
        'wrong_ugly' => [
            'message' => "You are wrong. Three pointers merge ugly multiples. This class merges two index lists of words.\nStep back to when you reused the ugly DP.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Map each word to increasing indices. Per query, two pointers on the two lists, advance the smaller, min abs. Do not rescan the dict, nest every pair, or keep only the last index.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
