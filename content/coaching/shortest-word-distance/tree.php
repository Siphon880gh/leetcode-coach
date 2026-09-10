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
            'message' => "Problem: wordsDict plus two different words that both appear. Return the smallest index gap. Length up to 3 × 10⁴. coding vs practice → 3; makes vs coding → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Collect every index of each word, then nested abs of every pair; or only adjacent words', 'next' => 'nested'],
                ['label' => 'One scan: keep latest i of word1 and j of word2; update min abs(i − j) once both exist', 'next' => 'scan'],
            ],
        ],
        'nested' => [
            'message' => "n² pairs blow the 3 × 10⁴ limit. Adjacent-only misses coding/practice (gap 3). Shortest Word Distance II preprocesses many queries; III allows word1 == word2. Here one query, distinct words.\nWhat is the O(n) walk?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'i = j = −1; on each hit overwrite that side; if both seen, ans = min(ans, abs(i − j))', 'next' => 'scan'],
                ['label' => 'Return the first time both words have appeared, then stop', 'next' => 'wrong_first'],
            ],
        ],
        'wrong_first' => [
            'message' => "You are wrong here.\nmakes appears twice; coding then the second makes is gap 1, closer than an earlier pair.\nStep back to when you stopped at the first pair.",
            'outcome' => 'wrong',
            'rewind_to' => 'nested',
            'choices' => [],
        ],
        'scan' => [
            'message' => "Latest index of each side is enough: the closest opposite so far is the previous other index. word1 != word2 so one position cannot be both. Samples: practice…coding is 3; makes…coding…makes is 1.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'coding vs practice → 3; makes vs coding → 1', 'next' => 'cpx'],
                ['label' => 'Valid Anagram: same letter counts, ignore positions', 'next' => 'wrong_ana'],
            ],
        ],
        'wrong_ana' => [
            'message' => "You are wrong. Anagrams compare bags of letters. This problem is index distance between two given words.\nStep back to when you reused the count array.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n), space O(1). Not n² pairs, not adjacent-only, not II’s map of lists, not III’s same-word rule.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'One scan, latest indices, min gap; not nested pairs, not first pair only', 'next' => 'success'],
                ['label' => 'Build a hash of word → all indices, then for this pair run nested loops', 'next' => 'wrong_hash'],
            ],
        ],
        'wrong_hash' => [
            'message' => "You are wrong. That preprocess is Distance II (many queries). One query does not need the map; the rolling last indices already see every pair that could be closest.\nStep back to when you built the index lists.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One pass, latest i and j, min abs(i − j) after both exist. Do not nest every pair, stop at the first pair, or require adjacent words. II and III are different problems.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
