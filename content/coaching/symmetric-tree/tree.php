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
            'message' => "Problem: is the tree a mirror of itself around the center? [1,2,2,3,4,4,3] → true. [1,2,2,null,3,null,3] → false. Nodes 1..1000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Same Tree: compare left-left and right-right on two copies of the tree', 'next' => 'same'],
                ['label' => 'dfs(a, b): both null true; else match vals and dfs(a.left, b.right) plus dfs(a.right, b.left)', 'next' => 'dfs'],
            ],
        ],
        'same' => [
            'message' => "Same Tree checks identical positions. A mirror pairs the outer children and the inner children. [1,2,2,3,4,4,3] is not two identical subtrees in the Same Tree sense unless you cross the sides.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Validate BST inorder, or Unique Paths counting grid walks', 'next' => 'wrong_bst'],
                ['label' => 'Call dfs(root.left, root.right) so the two halves are checked as mirrors', 'next' => 'dfs'],
            ],
        ],
        'wrong_bst' => [
            'message' => "You are wrong here.\nValidate BST is about sorted keys. Unique Paths counts routes. Symmetry is a crossed child pairing.\nStep back to when you reused BST or Unique Paths.",
            'outcome' => 'wrong',
            'rewind_to' => 'same',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "If a and b are both None, true. If one is None or a.val != b.val, false. Else AND the two crossed recursions. Time O(n).\nWhy dfs(a.left, b.right) instead of dfs(a.left, b.left)?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The left child of the left half must match the right child of the right half', 'next' => 'ret'],
                ['label' => 'Keep Same Tree’s pairing; a palindrome inorder list is enough', 'next' => 'wrong_inorder'],
            ],
        ],
        'wrong_inorder' => [
            'message' => "You are wrong. A palindrome inorder can miss structure (null vs a node on the opposite side), same trap as Same Tree vs inorder lists.\nStep back to when you used inorder or Same Tree pairing.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return dfs(root.left, root.right). A single-node tree is symmetric. Not a new tree.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A boolean: the two halves are mirrors', 'next' => 'success'],
                ['label' => 'Whether p and q are identical, like Same Tree on two inputs', 'next' => 'wrong_two'],
            ],
        ],
        'wrong_two' => [
            'message' => "You are wrong. Same Tree takes two roots. This problem has one root; you compare its left and right as mirrors.\nStep back to when you treated this as two input trees.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. dfs(root.left, root.right). Cross the children. O(n). Not Same Tree’s same-side pairing, not Validate BST, not Unique Paths, not an inorder palindrome.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
