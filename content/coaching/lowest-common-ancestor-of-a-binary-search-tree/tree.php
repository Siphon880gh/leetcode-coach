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
            'message' => "Problem: BST root, distinct nodes p and q both present, unique keys. Return their lowest common ancestor. A node is an ancestor of itself. [6,2,8,…], p=2, q=8 → 6. Same tree, p=2, q=4 → 2. Up to 10⁵ nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'LCA of a Binary Tree (236): recurse both children, or walk parents to the root and scan', 'next' => 'bt'],
                ['label' => 'From root: if both values are smaller go left; if both larger go right; else this node is the LCA', 'next' => 'walk'],
            ],
        ],
        'bt' => [
            'message' => "236 cannot assume left < node < right, so it searches both sides. Parent maps need O(n) extra. The BST search path is unique.\nHow do you use order?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'while true: if root.val < min(p,q) go right; elif root.val > max(p,q) go left; else return root', 'next' => 'walk'],
                ['label' => 'The LCA must sit strictly above p and q, so if root is p keep searching', 'next' => 'wrong_self'],
            ],
        ],
        'wrong_self' => [
            'message' => "You are wrong here.\nA node is an ancestor of itself. p=2, q=4 → 2, not 6.\nStep back to when you forbade the node from being the LCA.",
            'outcome' => 'wrong',
            'rewind_to' => 'bt',
            'choices' => [],
        ],
        'walk' => [
            'message' => "One value on each side of root, or root is p or q — that is the split. Iterative O(1) extra. Recursion is the same branch, O(h) stack.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'p=2 q=8 → 6; p=2 q=4 → 2; [2,1] p=2 q=1 → 2', 'next' => 'cpx'],
                ['label' => 'Recurse into both children at every node even when both keys sit on one side', 'next' => 'wrong_both'],
            ],
        ],
        'wrong_both' => [
            'message' => "You are wrong. That is 236. If both keys are smaller than root, only the left can hold the LCA.\nStep back to when you searched both sides.",
            'outcome' => 'wrong',
            'rewind_to' => 'walk',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(h) time, O(1) iterative. Not 236, not a parent map, not requiring a strict parent.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Walk until p and q split; not 236, not parent-walk, not forbidding self-ancestor', 'next' => 'success'],
                ['label' => 'Kth Smallest inorder dump, then scan the path between p and q in the array', 'next' => 'wrong_inorder'],
            ],
        ],
        'wrong_inorder' => [
            'message' => "You are wrong. Inorder lists values, not ancestors. The LCA is on the BST search path, not between two inorder indices.\nStep back to when you used an inorder dump.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. From the root, go right while both keys are larger, left while both are smaller, return the node where they split (or the node that is p or q). O(h) / O(1). Not 236, not a parent map, not inorder.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
