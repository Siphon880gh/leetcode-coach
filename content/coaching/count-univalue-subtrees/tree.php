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
            'message' => "Problem: how many subtrees have the same value on every node. Empty → 0. [5,1,5,5,5,null,5] → 4. [5,5,5,5,5,null,5] → 6.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count nodes equal to the root; or Closest BST Value: one search path, ignore children as subtrees', 'next' => 'root'],
                ['label' => 'Postorder: both child subtrees univalue, and each present child equals this node; then increment', 'next' => 'post'],
            ],
        ],
        'root' => [
            'message' => "The 1-rooted subtree in the first sample still has two univalue leaves. Same Tree compares two trees; here you count inside one tree.\nWhat does dfs return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Null → true without incrementing. Leaf increments. If a child subtree failed, this node fails too', 'next' => 'post'],
                ['label' => 'Increment on every null so the empty tree is 1', 'next' => 'wrong_null'],
            ],
        ],
        'wrong_null' => [
            'message' => "You are wrong here.\nThe empty sample is 0. Null is a vacuous match for the parent, not a subtree to count.\nStep back to when you counted null.",
            'outcome' => 'wrong',
            'rewind_to' => 'root',
            'choices' => [],
        ],
        'post' => [
            'message' => "If left or right is not univalue, return false. Else compare present children’s values to node.val (missing child treated as matching). Then ans += 1 and return true.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[5,1,5,…] → 4; all-5s tree → 6; [] → 0', 'next' => 'cpx'],
                ['label' => 'Skip leaves; only count internal nodes that match both children', 'next' => 'wrong_leaf'],
            ],
        ],
        'wrong_leaf' => [
            'message' => "You are wrong. A leaf is a univalue subtree of size 1. The sample 4 includes those leaves.\nStep back to when you skipped leaves.",
            'outcome' => 'wrong',
            'rewind_to' => 'post',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n), space O(h). Not “equal to root only,” not a BST closest walk, not increment-on-null.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Postorder boolean plus a counter; leaves count; null does not', 'next' => 'success'],
                ['label' => 'Group Shifted Strings: normalize first letter, ignore the tree', 'next' => 'wrong_shift'],
            ],
        ],
        'wrong_shift' => [
            'message' => "You are wrong. Caesar keys group strings. This walk is a tree DP on matching child values.\nStep back to when you hashed letters.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs: null is true, no increment. Recurse both sides. Fail if a side is not univalue or a present child differs. Else increment and return true. Leaves count.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
