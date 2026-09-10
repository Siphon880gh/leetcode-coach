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
            'message' => "Problem: round-trip a binary tree through a string. [1,2,3,null,null,4,5] round-trips. Empty → empty string. Values −1000..1000, up to 10⁴ nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Inorder only, or skip nulls like Serialize BST (449)', 'next' => 'wrong_shape'],
                ['label' => 'BFS: write val or #, enqueue both children including null', 'next' => 'bfs'],
            ],
        ],
        'wrong_shape' => [
            'message' => "You are wrong here.\nInorder loses structure. A BST can skip nulls; a general tree cannot. [1,null,2] and [1,2] collide without sentinels.\nStep back to when you dropped # or used inorder only.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'bfs' => [
            'message' => "Serialize: empty root → empty string. Else BFS; live node → append val and enqueue left and right; null → append #. Join with commas. Deserialize: split; first token is root; for each live node, next two tokens are left and right (# stays null).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'eval a Python tree literal, or reuse Encode and Decode Strings (271)', 'next' => 'wrong_eval'],
                ['label' => 'O(n) time and space. Queue of built nodes, not of #', 'next' => 'cpx'],
            ],
        ],
        'wrong_eval' => [
            'message' => "You are wrong. eval is not a codec. 271 prefixes list lengths, not tree holes.\nStep back to when you reused 271 or eval.",
            'outcome' => 'wrong',
            'rewind_to' => 'bfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Preorder with # also works if encode and decode share the same walk. Empty string, not a lone #, for an empty tree in this BFS format.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sentinels in BFS both ways. Not inorder, not 271, not skipping nulls', 'next' => 'success'],
                ['label' => 'Omit trailing # tokens; decode will still know the right child is missing', 'next' => 'wrong_trim'],
            ],
        ],
        'wrong_trim' => [
            'message' => "You are wrong. The decoder reads two tokens per live node. Dropping trailing # desyncs left and right.\nStep back to when you trimmed sentinels.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Level-order with # for null. Enqueue children of live nodes. Decode from a queue of built nodes. Empty tree is the empty string. O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
