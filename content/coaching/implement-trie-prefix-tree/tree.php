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
            'message' => "Problem: Trie with insert, search (full word), startsWith (any inserted word has that prefix). Lowercase only. After insert(\"apple\"): search(\"apple\") true, search(\"app\") false, startsWith(\"app\") true; then insert(\"app\") makes search(\"app\") true.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep a hash set of whole words; startsWith scans every word', 'next' => 'hashset'],
                ['label' => 'Each node: 26 child slots plus isEnd; walk letters; mark the last node', 'next' => 'trie'],
            ],
        ],
        'hashset' => [
            'message' => "A set of whole words makes insert and search easy, but startsWith scans every stored string. Up to 3×10⁴ mixed calls, that is too slow. Course Schedule peels a DAG; this is a prefix tree.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Kahn leftover nodes: return false if any in-degree remains', 'next' => 'wrong_kahn'],
                ['label' => 'Shared prefixes share nodes; children[c − a]; isEnd only on a completed word', 'next' => 'trie'],
            ],
        ],
        'wrong_kahn' => [
            'message' => "You are wrong here.\nKahn is Course Schedule. A trie walks characters, not in-degrees.\nStep back to when you reused Kahn.",
            'outcome' => 'wrong',
            'rewind_to' => 'hashset',
            'choices' => [],
        ],
        'trie' => [
            'message' => "insert: from the root, create a missing child, step, set isEnd at the end. Walk the same path for queries. startsWith is true if the walk finishes. search is true only if it finishes and isEnd is true.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'insert apple: search app is false, startsWith app is true; insert app then search app is true', 'next' => 'cpx'],
                ['label' => 'After insert apple, search app is true because apple starts with app', 'next' => 'wrong_search'],
            ],
        ],
        'wrong_search' => [
            'message' => "You are wrong. search needs isEnd. apple leaves isEnd on e, not on the second p. startsWith(\"app\") is the prefix check.\nStep back to when you treated search like startsWith.",
            'outcome' => 'wrong',
            'rewind_to' => 'trie',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(m) per call for word length m. Array children use 26 slots per node. Hash-map children are the same idea for a sparse alphabet.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Walk or create; search = path and isEnd; startsWith = path only; not a word set, not Kahn', 'next' => 'success'],
                ['label' => 'startsWith must also require isEnd so prefixes of longer words fail', 'next' => 'wrong_prefix'],
            ],
        ],
        'wrong_prefix' => [
            'message' => "You are wrong. startsWith(\"app\") is true after insert(\"apple\"). Requiring isEnd would make it the same as search.\nStep back to when you added isEnd to startsWith.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. 26 children, isEnd on a full word. insert marks the last node. search needs the path and isEnd. startsWith only needs the path. O(m) per op. Not a whole-word set, not Kahn, not treating search as startsWith.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
