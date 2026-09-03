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
            'message' => "Problem: return preorder values of a binary tree. [1,null,2,3] → [1,2,3]. Empty → []. Inorder of that tree would be [1,3,2]. Up to 100 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Inorder’s left then visit, postorder’s children then root, or BFS level order', 'next' => 'order'],
                ['label' => 'DFS: append root.val, recurse left, recurse right', 'next' => 'dfs'],
            ],
        ],
        'order' => [
            'message' => "Inorder on the sample is 1,3,2. Postorder is 3,2,1. Level order happens to be 1,2,3 on this skinny tree but fails on a left child: [1,2] is [1,2] preorder and also BFS — use [1,2,3,4,5] → preorder [1,2,4,5,3] not BFS [1,2,3,4,5].\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Same as Linked List Cycle Floyd, or Reorder List’s mid cut', 'next' => 'wrong_other'],
                ['label' => 'Visit this node before either child; left subtree before right', 'next' => 'dfs'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nFloyd and reorder are list pointer tricks, not tree DFS order.\nStep back to when you copied those APIs.",
            'outcome' => 'wrong',
            'rewind_to' => 'order',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "if root is None: return. ans.append(val); dfs(left); dfs(right). Iterative: stack, pop, append, push right then left so left is on top.\nWhy push right before left?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A stack pops last-in first; left must be processed next, so it is pushed second', 'next' => 'ret'],
                ['label' => 'Push left first so the right child is visited before the left', 'next' => 'wrong_stk'],
            ],
        ],
        'wrong_stk' => [
            'message' => "You are wrong. Pushing left first would emit right-then-left, which is not preorder.\nStep back to when you reversed the stack order.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Time O(n). [1] → [1]. [] → []. Return the list of values, not a rebuilt tree.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The preorder list — visit, left, right — not inorder, not postorder, not BFS', 'next' => 'success'],
                ['label' => 'The inorder list [1,3,2] for the sample, because that is the usual BST walk', 'next' => 'wrong_in'],
            ],
        ],
        'wrong_in' => [
            'message' => "You are wrong. Preorder of [1,null,2,3] is [1,2,3]. Inorder is a different problem.\nStep back to when you returned inorder.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Visit, then left, then right. O(n). Iterative stack pushes right then left. Not inorder, not postorder, not BFS, not Floyd, not Reorder List.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
