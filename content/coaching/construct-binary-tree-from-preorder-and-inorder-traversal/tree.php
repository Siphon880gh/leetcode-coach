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
            'message' => "Problem: build the tree from preorder and inorder. Unique values. preorder=[3,9,20,15,7], inorder=[9,3,15,20,7] → [3,9,20,null,null,15,7]. Length 1..3000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the inorder list, or Unique BST II generating every shape on 1..n', 'next' => 'list'],
                ['label' => 'preorder[i] is the root; find it in inorder to split left and right sizes', 'next' => 'dfs'],
            ],
        ],
        'list' => [
            'message' => "Inorder Traversal emits values; here you already have those lists and must allocate nodes. Unique BST II enumerates Catalan trees, not this unique pair of traversals.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Max Depth: 1 + max of children, return an integer', 'next' => 'wrong_depth'],
                ['label' => 'Hash inorder index; dfs(i, j, n) builds n nodes starting at those offsets', 'next' => 'dfs'],
            ],
        ],
        'wrong_depth' => [
            'message' => "You are wrong here.\nMax Depth returns a number. This returns a TreeNode.\nStep back to when you reused Max Depth.",
            'outcome' => 'wrong',
            'rewind_to' => 'list',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "If n ≤ 0, return None. v = preorder[i], k = d[v]. Left size is k-j. Left: dfs(i+1, j, k-j). Right: dfs(i+1+k-j, k+1, n-k+j-1). Time O(n) with the map.\nWhy not scan inorder for v every call?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Values are unique, so one hashmap of inorder index is O(1) per root', 'next' => 'ret'],
                ['label' => 'Level Order BFS to attach children left-to-right from the preorder array', 'next' => 'wrong_bfs'],
            ],
        ],
        'wrong_bfs' => [
            'message' => "You are wrong. Preorder is root-left-right, not level order. You cannot fill a queue from preorder the way Level Order listed rows.\nStep back to when you used BFS.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return dfs(0, 0, len(preorder)). A single value [-1] is one node.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The root of the reconstructed tree', 'next' => 'success'],
                ['label' => 'Whether the two lists match, like Same Tree on two inputs', 'next' => 'wrong_same'],
            ],
        ],
        'wrong_same' => [
            'message' => "You are wrong. Same Tree compares two trees. This builds one tree from two arrays.\nStep back to when you returned a boolean.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Map inorder indices. dfs: preorder[i] is root; left size from the inorder split; recurse both sides. O(n). Not Unique BST II, not Max Depth, not Level Order, not Same Tree.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
