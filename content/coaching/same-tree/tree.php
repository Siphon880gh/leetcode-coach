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
            'message' => "Problem: are trees p and q the same — same structure and same values? [1,2,3] vs [1,2,3] → true. [1,2] vs [1,null,2] → false. [1,2,1] vs [1,1,2] → false. Up to 100 nodes each; either may be empty.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Compare inorder lists, or Validate BST’s strictly increasing walk', 'next' => 'inorder'],
                ['label' => 'DFS: both null true; one null or vals differ false; else match left-left and right-right', 'next' => 'dfs'],
            ],
        ],
        'inorder' => [
            'message' => "Inorder of [1,2,1] and [1,1,2] can collide or miss a missing child. Validate BST checks order on one tree, not identity of two.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'BFS Unique Paths: count routes instead of comparing nodes', 'next' => 'wrong_paths'],
                ['label' => 'At each pair of nodes, require the same nullness, value, then both child pairs', 'next' => 'dfs'],
            ],
        ],
        'wrong_paths' => [
            'message' => "You are wrong here.\nUnique Paths counts grid walks. Same Tree returns whether two trees are copies of each other.\nStep back to when you reused Unique Paths.",
            'outcome' => 'wrong',
            'rewind_to' => 'inorder',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "If p and q are both None, true. If exactly one is None, or p.val != q.val, false. Else return isSame(p.left, q.left) and isSame(p.right, q.right). Time O(min(m, n)).\nWhy not only compare values and ignore null children?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,2] vs [1,null,2] share values 1,2 but the 2 sits on opposite sides', 'next' => 'ret'],
                ['label' => 'A missing child is the same as a child whose value is 0', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. Null is structure, not the number 0. Constraints allow other values; absence of a node is a mismatch if the other tree has one.\nStep back to when you treated null as 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Two empty trees are the same. Return a boolean, not a merged tree.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'True iff every corresponding pair matched, including nulls', 'next' => 'success'],
                ['label' => 'Whether one tree is a mirror of the other (Symmetric Tree)', 'next' => 'wrong_sym'],
            ],
        ],
        'wrong_sym' => [
            'message' => "You are wrong. Symmetric Tree compares a tree to its mirror. Same Tree compares p to q in the same left/right positions.\nStep back to when you checked a mirror.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Both null → true. One null or unequal val → false. Else AND the two child pairs. O(min(m, n)). Not inorder lists, not Validate BST, not Unique Paths, not Symmetric Tree.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
