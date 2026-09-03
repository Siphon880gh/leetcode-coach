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
            'message' => "Problem: all structurally unique BSTs using each value 1..n once. n = 3 → five trees. n = 1 → [[1]]. n ≤ 8.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count grid paths like Unique Paths, or only list inorder like problem 94', 'next' => 'count'],
                ['label' => 'dfs(i, j): each v in i..j is root; pair every left tree on [i, v-1] with every right on [v+1, j]', 'next' => 'dfs'],
            ],
        ],
        'count' => [
            'message' => "Unique Paths counts routes on a grid. Inorder lists values of one tree. Here you must build every shape whose inorder is 1..n (BST property).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the Catalan number G(n) only, like Unique BST I', 'next' => 'wrong_cat'],
                ['label' => 'Enumerate the root; left subtree uses smaller keys, right uses larger', 'next' => 'dfs'],
            ],
        ],
        'wrong_cat' => [
            'message' => "You are wrong here.\nUnique BST I returns how many. This problem returns the trees themselves.\nStep back to when you returned a count.",
            'outcome' => 'wrong',
            'rewind_to' => 'count',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "When i > j, return a list containing None. Why not an empty list?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The nested loops still need one “empty child” so a missing side is a valid pairing', 'next' => 'ret'],
                ['label' => 'Empty list is fine; then no TreeNode is ever built for that root', 'next' => 'wrong_empty'],
            ],
        ],
        'wrong_empty' => [
            'message' => "You are wrong. If the empty range returns [], the cartesian product has zero pairs and you drop every tree that should have a null child.\nStep back to when you returned [].",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Answer is dfs(1, n). Time on the order of n times the Catalan number. Not N-Queens boards, not Subsets of integers.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A list of tree roots, any order', 'next' => 'success'],
                ['label' => 'One inorder array [1,2,…,n] for every shape', 'next' => 'wrong_inorder'],
            ],
        ],
        'wrong_inorder' => [
            'message' => "You are wrong. Every BST on 1..n has the same inorder. The output is distinct shapes, not repeated value lists.\nStep back to when you returned inorder arrays.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs(i, j): i>j → [None]; else for each root v, cartesian product of dfs(i, v-1) and dfs(v+1, j). Return dfs(1, n). Not Unique Paths, not Unique BST I’s count, not inorder listing.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
