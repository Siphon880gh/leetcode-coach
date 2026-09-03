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
            'message' => "Problem: return postorder values of a binary tree. [1,null,2,3] → [3,2,1]. Preorder of that tree is [1,2,3]. Inorder is [1,3,2]. Empty → []. Up to 100 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Preorder’s visit first, inorder’s visit between children, or BFS level order', 'next' => 'order'],
                ['label' => 'DFS: recurse left, recurse right, then append root.val', 'next' => 'dfs'],
            ],
        ],
        'order' => [
            'message' => "Visit-first is preorder [1,2,3]. Visit-between is inorder [1,3,2]. BFS is 1,2,3 on this skinny tree.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Floyd mid-cut, or Unique BST I’s Catalan count', 'next' => 'wrong_other'],
                ['label' => 'Both children first, this node last: left subtree, right subtree, then val', 'next' => 'dfs'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nFloyd is a list cycle trick. Catalan counts trees, it does not list values.\nStep back to when you copied those APIs.",
            'outcome' => 'wrong',
            'rewind_to' => 'order',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "if root is None: return. dfs(left); dfs(right); ans.append(val). Time O(n). An iterative trick is reverse of root-right-left preorder.\nWhy append after both recursive calls?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Postorder means the node is recorded only after its subtrees are done', 'next' => 'ret'],
                ['label' => 'You can append first like preorder; the sample still comes out [3,2,1]', 'next' => 'wrong_pre'],
            ],
        ],
        'wrong_pre' => [
            'message' => "You are wrong. Appending first is preorder and yields [1,2,3] on the sample.\nStep back to when you visited before the children.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "[1] → [1]. [] → []. Return the list of values, not a rebuilt tree.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The postorder list — left, right, visit — not preorder, not inorder, not BFS', 'next' => 'success'],
                ['label' => 'The preorder list [1,2,3] for the sample', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. Postorder of [1,null,2,3] is [3,2,1]. Preorder is the previous session.\nStep back to when you returned preorder.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Left, then right, then visit. O(n). Not preorder, not inorder, not BFS, not Floyd, not Catalan.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
