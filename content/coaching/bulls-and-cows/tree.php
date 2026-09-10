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
            'message' => "Problem: secret and guess, same length, digits. Return xAyB. Bulls: same digit and same index. Cows: leftover digits that could rearrange into bulls. \"1807\" / \"7810\" → 1A3B. \"1123\" / \"0111\" → 1A1B.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat it as Guess Number or First Bad Version (binary search API)', 'next' => 'wrong_kind'],
                ['label' => 'Count bulls in place first; cows are min of leftover digit bags', 'next' => 'count'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong here.\nGuess Number / First Bad Version is a different API. Here you score one pair of strings in one pass.\nStep back to when you reused a binary-search guess game.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'count' => [
            'message' => "Zip the two strings. Equal pair → increment bulls. Unequal pair → increment cnt1[secret digit] and cnt2[guess digit]. Then cows = sum over 0..9 of min(cnt1[d], cnt2[d]). Return xAyB.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count a bull digit again as a cow, or let two guess 1s share one secret 1', 'next' => 'wrong_reuse'],
                ['label' => 'O(n) time, ten digit buckets. Do not require unique digits', 'next' => 'cpx'],
            ],
        ],
        'wrong_reuse' => [
            'message' => "You are wrong. Bulls are stripped before the leftover bags. \"1123\" / \"0111\" has one bull 1; only one leftover secret 1 remains, so cows = 1 (1A1B), not 1A2B.\nStep back to when you double-counted a digit.",
            'outcome' => 'wrong',
            'rewind_to' => 'count',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Duplicates are allowed. A permutation of the whole guess would mix bulls into cows. Space is ten counters, not a map of the full string.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Bulls first, then min leftover counts. Format xAyB. Not Guess Number', 'next' => 'success'],
                ['label' => 'Score the whole guess as a permutation, including positions that already matched', 'next' => 'wrong_perm'],
            ],
        ],
        'wrong_perm' => [
            'message' => "You are wrong. Cows are a rearrangement of the non-bull leftovers only. Matched positions are already bulls and must not enter the bags.\nStep back to when you permuted the whole guess.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Count bulls in place. Bag leftover digits; cows are the min per digit. \"1123\" / \"0111\" is 1A1B. O(n), ten buckets.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
