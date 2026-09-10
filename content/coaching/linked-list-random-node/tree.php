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
            'message' => "Problem: singly linked list, length 1..1e4. getRandom returns a node value; every node equally likely. At most 1e4 calls. Example [1, 2, 3]: each has probability 1/3. Follow-up: the list may be huge and the length unknown — no extra array of values.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy every value into an array (or reuse GetRandom 380), then pick an index', 'next' => 'wrong_arr'],
                ['label' => 'Reservoir of size 1: walk from head; at the k-th node replace with chance 1/k', 'next' => 'res'],
            ],
        ],
        'wrong_arr' => [
            'message' => "You are wrong here. An array is O(n) extra space. 380 needs an indexable bag you already own. The follow-up forbids storing all values.\nStep back to when you copied the list or used 380.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'res' => [
            'message' => "Keep ans and a counter k starting at 0. For each node, increment k and draw randint(1, k); if the draw equals k, set ans to this value. After the tail, ans is uniform: node i is chosen with 1/i and survives later replacements with i/(i+1) × … × (n−1)/n = 1/n.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Pick head with a fixed coin and ignore later nodes, or skip a node after committing ans', 'next' => 'wrong_head'],
                ['label' => 'Visit every node; replace only when the draw equals the running count k', 'next' => 'kind'],
            ],
        ],
        'wrong_head' => [
            'message' => "You are wrong. A coin that ignores k biases the head. You must still walk the rest of the list after you have an answer.\nStep back to when you froze the first pick.",
            'outcome' => 'wrong',
            'rewind_to' => 'res',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Random Pick Index (398) is the same 1/k walk on matching array indices. Do not assume you stored n unless you counted it on this pass.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'One-pass reservoir. [1,2,3] each 1/3. Not 380', 'next' => 'success'],
                ['label' => 'Assume n is known without walking, or pick only among the first two nodes', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. Length is discovered while you walk. Stopping early is not uniform over the whole list.\nStep back to when you assumed n or truncated the walk.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Replace with chance 1/k at the k-th node. [1,2,3] each 1/3. Follow-up uses O(1) extra. Not 380.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
