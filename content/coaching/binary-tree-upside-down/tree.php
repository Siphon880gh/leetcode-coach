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
            'message' => "Problem: turn a binary tree upside down. Original left becomes the new root; original root becomes the new right; original right becomes the new left. [1,2,3,4,5] → [4,5,2,null,null,3,1]. Every right has a left sibling and no kids. At most 10 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Swap left and right like invert/symmetric, Flatten Tree’s preorder spine, Min Stack, or BFS level reverse', 'next' => 'invert'],
                ['label' => 'Recurse down the left spine; then left.right = root, left.left = root.right; clear root’s kids; return the leftmost', 'next' => 'spine'],
            ],
        ],
        'invert' => [
            'message' => "Invert swaps children under the same root; 1 would still be the root. Flatten puts everything on the right. Min Stack is a design problem. Level reverse is zigzag/level-order II.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return root unchanged after swapping 2 and 3', 'next' => 'wrong_swap'],
                ['label' => 'The new root is the old leftmost leaf; rewire on the way back up the left chain', 'next' => 'spine'],
            ],
        ],
        'wrong_swap' => [
            'message' => "You are wrong here.\n[1,2,3,4,5] must become rooted at 4, not at 1. Swapping siblings is Invert Binary Tree, not this.\nStep back to when you inverted.",
            'outcome' => 'wrong',
            'rewind_to' => 'invert',
            'choices' => [],
        ],
        'spine' => [
            'message' => "Base: empty or no left → return root. Else new_root = recurse(root.left). Then root.left.right = root; root.left.left = root.right; root.left = root.right = None. Return new_root (not the old root).\nWhy clear root’s children?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Otherwise the old root still points at the new parent and cycles', 'next' => 'ret'],
                ['label' => 'Leave them; Flatten Tree keeps a right spine on purpose', 'next' => 'wrong_cycle'],
            ],
        ],
        'wrong_cycle' => [
            'message' => "You are wrong. After 2 becomes parent of 1, 1.left still pointing at 2 loops. Flatten’s right spine is a different problem.\nStep back to when you skipped the null-out.",
            'outcome' => 'wrong',
            'rewind_to' => 'spine',
            'choices' => [],
        ],
        'ret' => [
            'message' => "[] → []. [1] → [1]. Time O(n), extra O(height) from the left-spine recursion. Rights have no children, so you never recurse on the right.\nWhat is the new root of [1,2,3,4,5]?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '4 — leftmost leaf; 5 is its left, 2 its right', 'next' => 'success'],
                ['label' => '1 still, or 2 like a flatten head', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. The sample output is rooted at 4, not 1 or 2.\nStep back to when you kept the old root.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Recurse left; rewire left.right = root, left.left = old right; null the old root; return the leftmost. Not invert, not flatten, not Min Stack, not BFS reverse. [4,5,2,null,null,3,1].\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
