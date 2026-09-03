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
            'message' => "Problem: return inorder values of a binary tree. [1,null,2,3] → [1,3,2]. Empty → []. Up to 100 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Visit root first (preorder), or walk level by level (BFS)', 'next' => 'order'],
                ['label' => 'DFS: recurse left, append root.val, recurse right', 'next' => 'dfs'],
            ],
        ],
        'order' => [
            'message' => "Preorder would emit 1 then 2 then 3. Level order would emit 1 then 2 then 3. The sample is 1, 3, 2 — left subtree of 2 before 2 itself.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Postorder: left, right, then root — that would put 1 last', 'next' => 'wrong_post'],
                ['label' => 'Inorder is left subtree, then this node, then right subtree', 'next' => 'dfs'],
            ],
        ],
        'wrong_post' => [
            'message' => "You are wrong here.\nPostorder visits the node after both children. Inorder visits it between them.\nStep back to when you chose postorder.",
            'outcome' => 'wrong',
            'rewind_to' => 'order',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "If root is None, return without appending. An iterative stack that pushes the left spine, pops, then goes right, yields the same order. Time O(n).\nWhy not treat this like Valid Parentheses’ stack of openers?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The stack here stores pending tree nodes, not unmatched ( characters', 'next' => 'ret'],
                ['label' => 'Push every node like matching brackets; pop when left equals right', 'next' => 'wrong_paren'],
            ],
        ],
        'wrong_paren' => [
            'message' => "You are wrong. Valid Parentheses matches delimiters in a string. Inorder walks a tree’s left spine.\nStep back to when you reused parentheses matching.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Single node [1] → [1]. Null root → []. Not Restore IP (string splits).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The list of values in inorder — not a count, not the tree itself', 'next' => 'success'],
                ['label' => 'A rebuilt tree, like Unique Binary Search Trees later', 'next' => 'wrong_build'],
            ],
        ],
        'wrong_build' => [
            'message' => "You are wrong. This problem only lists values. You do not construct new nodes.\nStep back to when you returned a tree.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs: if None return; left; append val; right. O(n). Inorder is not preorder, not postorder, not BFS. Empty tree is [].\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
