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
            'message' => "Problem: binary tree (not necessarily a BST), distinct nodes p and q both present. Return their lowest common ancestor. A node is an ancestor of itself. [3,5,1,…], p=5, q=1 → 3. Same tree, p=5, q=4 → 5. Up to 10⁵ nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'LCA of a BST (235): walk left/right by key, or pick the first node whose val sits between p and q', 'next' => 'bst'],
                ['label' => 'dfs: null/p/q returns the node; both children hit → this node; else bubble the nonempty side', 'next' => 'dfs'],
            ],
        ],
        'bst' => [
            'message' => "This tree has no left < node < right. 4 can sit under 5, not under 3; a between-val test would pick 3 wrongly. You must search both subtrees.\nHow do you combine the two searches?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'left = dfs(left), right = dfs(right). If both non-null return node. Else return left or right', 'next' => 'dfs'],
                ['label' => 'The LCA must sit strictly above p and q, so if the node is p keep searching the other subtree only for a parent', 'next' => 'wrong_self'],
            ],
        ],
        'wrong_self' => [
            'message' => "You are wrong here.\nA node is an ancestor of itself. p=5, q=4 → 5, not 3.\nStep back to when you forbade the node from being the LCA.",
            'outcome' => 'wrong',
            'rewind_to' => 'bst',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "If node is p or q, return it (do not keep searching below). The nested target sits under that hit, so a single-sided bubble is the LCA. If both sides return a node, this is the split. Compare node identity, not a copied val.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'p=5 q=1 → 3; p=5 q=4 → 5; [1,2] p=1 q=2 → 1', 'next' => 'cpx'],
                ['label' => 'If only the left hits, keep scanning the right until both hits, even when the node already is p', 'next' => 'wrong_scan'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong. Returning p immediately is correct: the other node is nested under p when p is the LCA. Scanning further is 235-style extra work and can pick a wrong ancestor.\nStep back to when you refused to return p.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(h) stack. Not 235, not a between-val test, not requiring a strict parent.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Both sides hit → this node; else bubble; not 235, not between-val, not forbidding self-ancestor', 'next' => 'success'],
                ['label' => 'Build a parent map, walk both to the root, scan the first shared node — that is the only correct answer', 'next' => 'wrong_parent'],
            ],
        ],
        'wrong_parent' => [
            'message' => "You are wrong. A parent map works but uses O(n) extra; the postorder both-sides check is the intended O(h) extra walk.\nStep back to when you treated the parent map as required.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs returns the node if it is p or q. Both children non-null → this is the split. Else bubble the hit. O(n) / O(h). Not 235, not a between-val test, not forbidding self-ancestor.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
