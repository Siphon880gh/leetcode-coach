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
            'message' => "Problem: words claimed sorted in an unknown alphabet. Return any string of the unique letters in that order, or empty if impossible. [\"wrt\",\"wrf\",\"er\",\"ett\",\"rftt\"] → wertf. [\"z\",\"x\"] → zx. [\"z\",\"x\",\"z\"] → empty.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort the unique letters in English a..z, or Course Schedule II on a given edge list', 'next' => 'eng'],
                ['label' => 'Compare consecutive words; first differing letters become an edge earlier → later; then Kahn', 'next' => 'pair'],
            ],
        ],
        'eng' => [
            'message' => "English order is not the alien order. Course Schedule II already has prerequisites; here you must derive edges from the dictionary.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Compare only the first character of each word and ignore the rest', 'next' => 'wrong_first'],
                ['label' => 'Walk the shared prefix of each adjacent pair; at the first mismatch, add c1 → c2', 'next' => 'pair'],
            ],
        ],
        'wrong_first' => [
            'message' => "You are wrong here.\n\"wrt\" then \"wrf\" differs at the third letter: t before f. The first letter is the same.\nStep back to when you used only the first character.",
            'outcome' => 'wrong',
            'rewind_to' => 'eng',
            'choices' => [],
        ],
        'pair' => [
            'message' => "If the earlier word is longer and the later is a prefix ([\"abc\",\"ab\"]), return empty. If the reverse edge already exists, empty. Nodes are letters that appear, not all 26.\nThen what?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Kahn-peel in-degree 0 among letters that appear; leftover nodes mean a cycle → empty', 'next' => 'cpx'],
                ['label' => 'Emit every a..z letter even if it never showed up in words', 'next' => 'wrong_all'],
            ],
        ],
        'wrong_all' => [
            'message' => "You are wrong. Only unique letters that appear belong in the answer.\nStep back to when you padded the alphabet.",
            'outcome' => 'wrong',
            'rewind_to' => 'pair',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "[\"z\",\"x\",\"z\"] cycles. Any valid topo order is allowed. Time is linear in total characters plus 26.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Adjacent pairs → edges; prefix-of-longer invalid; Kahn on appearing letters. Not English sort', 'next' => 'success'],
                ['label' => 'A leftover in-degree is fine; return the partial peel', 'next' => 'wrong_part'],
            ],
        ],
        'wrong_part' => [
            'message' => "You are wrong. If ans is shorter than the count of distinct letters, a cycle remains — return empty.\nStep back to when you kept a prefix.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Consecutive words, first mismatch is earlier → later. Prefix-of-longer and reverse edges fail. Kahn on letters that appear; leftover → empty. Not English a..z, not 210’s given list, not unused letters.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
