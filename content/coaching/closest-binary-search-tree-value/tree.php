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
            'message' => "Problem: BST root and a float target. Return the closest node value. On a tie, the smaller. [4,2,5,1,3], target 3.714286 → 4. Single node [1] → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Inorder dump every value then scan, or Closest BST Value II’s window of k neighbors', 'next' => 'dump'],
                ['label' => 'One search path: keep a closer (or equal-and-smaller) ans; go left if target is smaller', 'next' => 'walk'],
            ],
        ],
        'dump' => [
            'message' => "A full inorder is O(n). 272 asks for k closest, not one. You only need the nodes on a binary-search path.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Recurse into both children like LCA of a binary tree (236)', 'next' => 'wrong_both'],
                ['label' => 'At each node update ans by abs(val − target); then take left or right, never both', 'next' => 'walk'],
            ],
        ],
        'wrong_both' => [
            'message' => "You are wrong here.\nBST order tells you which side can still beat the current gap. Visiting both is a full tree walk.\nStep back to when you forked both ways.",
            'outcome' => 'wrong',
            'rewind_to' => 'dump',
            'choices' => [],
        ],
        'walk' => [
            'message' => "If the new gap equals the best and node.val < ans, keep the smaller. Then node = left if target < node.val else right.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[4,2,5,1,3], target ≈ 3.71 → 4. On a 2-vs-4 tie at 3, pick 2', 'next' => 'cpx'],
                ['label' => 'On a tie pick the larger value', 'next' => 'wrong_tie'],
            ],
        ],
        'wrong_tie' => [
            'message' => "You are wrong. The problem asks for the smaller when two values are equally close.\nStep back to when you kept the larger.",
            'outcome' => 'wrong',
            'rewind_to' => 'walk',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(h) typical, O(n) worst, O(1) extra iterative. Kth Smallest is an inorder rank, not a target gap.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Search-path update; smaller on a tie. Not a full dump, not 272, not both children', 'next' => 'success'],
                ['label' => 'Inorder Successor: return the smallest key greater than target, ignore closer smaller keys', 'next' => 'wrong_succ'],
            ],
        ],
        'wrong_succ' => [
            'message' => "You are wrong. Successor is the next larger key. Closest can be smaller than target (2 is closer to 2.1 than 4 is).\nStep back to when you required greater-than.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One BST search path. Update on a tighter gap or an equal gap with a smaller value. Left if target is smaller. Not a full inorder, not 272, not both children, not successor.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
