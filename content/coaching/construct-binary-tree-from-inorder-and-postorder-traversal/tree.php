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
            'message' => "Problem: build the tree from inorder and postorder. Unique values. inorder=[9,3,15,20,7], postorder=[9,15,7,20,3] → [3,9,20,null,null,15,7]. Length 1..3000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reuse 105: treat postorder[0] as the root like preorder', 'next' => 'pre'],
                ['label' => 'The last postorder value is the root; split inorder at that value', 'next' => 'dfs'],
            ],
        ],
        'pre' => [
            'message' => "Preorder starts at the root. Postorder finishes at the root. Taking postorder[0] here would pick 9, which is a left leaf, not 3.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Level Order BFS, or Unique BST II generating every Catalan shape', 'next' => 'wrong_bfs'],
                ['label' => 'Map inorder indices; dfs(i, j, n) uses postorder[j+n-1] as v', 'next' => 'dfs'],
            ],
        ],
        'wrong_bfs' => [
            'message' => "You are wrong here.\nLevel Order lists rows. Unique BST II enumerates trees. This reconstructs one tree from two arrays.\nStep back to when you left the postorder root.",
            'outcome' => 'wrong',
            'rewind_to' => 'pre',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "If n ≤ 0, None. v = postorder[j+n-1], k = d[v]. Left: dfs(i, j, k-i). Right: dfs(k+1, j+k-i, n-k+i-1). Time O(n).\nWhy is the right subtree’s postorder start j+k-i?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Postorder is left, then right, then root — skip the left block of size k-i', 'next' => 'ret'],
                ['label' => 'Same offsets as 105’s preorder dfs(i+1, …); postorder is just preorder reversed', 'next' => 'wrong_rev'],
            ],
        ],
        'wrong_rev' => [
            'message' => "You are wrong. Reversing preorder is not postorder (left/right order stays left-then-right). You must index the last of the current postorder slice.\nStep back to when you reversed 105.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return dfs(0, 0, len(inorder)). Single value [-1] is one node.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The reconstructed root, not a boolean or a depth', 'next' => 'success'],
                ['label' => 'The inorder list, like Binary Tree Inorder Traversal', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. You are given inorder already. The output is a tree.\nStep back to when you returned the array.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Root is postorder[j+n-1]. Hash inorder. Split sizes; recurse left then right. O(n). Not 105’s first-of-preorder, not Unique BST II, not Level Order, not reversing preorder.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
