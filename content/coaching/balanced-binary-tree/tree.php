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
            'message' => "Problem: is the tree height-balanced? [3,9,20,null,null,15,7] → true. [1,2,2,3,3,null,null,4,4] → false. Empty → true. Up to 5000 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return Max Depth’s integer, or rebuild like Convert Sorted Array to BST', 'next' => 'depth'],
                ['label' => 'Bottom-up height: -1 means unbalanced; else 1 + max(left, right)', 'next' => 'h'],
            ],
        ],
        'depth' => [
            'message' => "Max Depth is a number. Convert Sorted Array builds a tree. This is a yes/no on an existing tree: every node’s two subtree heights differ by at most 1.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Validate BST (inorder strictly increasing) or Unique BST I count', 'next' => 'wrong_bst'],
                ['label' => 'height(None)=0; if l==-1 or r==-1 or abs(l-r)>1 return -1', 'next' => 'h'],
            ],
        ],
        'wrong_bst' => [
            'message' => "You are wrong here.\nValidate BST checks order. Unique BST I counts trees. Balance is about heights, not values.\nStep back to when you reused a BST-order problem.",
            'outcome' => 'wrong',
            'rewind_to' => 'depth',
            'choices' => [],
        ],
        'h' => [
            'message' => "Return height(root) >= 0. Time O(n) because each node is visited once and a -1 bubbles up.\nWhy not call a separate max-depth on every node from the top?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Top-down height at every node repeats work and can be O(n²)', 'next' => 'ret'],
                ['label' => 'Only the root’s two children need |l-r|≤1; descendants can tilt', 'next' => 'wrong_root'],
            ],
        ],
        'wrong_root' => [
            'message' => "You are wrong. Height-balanced means every node, not just the root. Example 2 fails deeper than the root.\nStep back to when you checked only the root.",
            'outcome' => 'wrong',
            'rewind_to' => 'h',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Empty tree: height 0 ≥ 0 → true. Not a rebuilt tree and not a depth integer.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A boolean: true iff no subtree returned -1', 'next' => 'success'],
                ['label' => 'The height integer like Maximum Depth of Binary Tree', 'next' => 'wrong_int'],
            ],
        ],
        'wrong_int' => [
            'message' => "You are wrong. The judge wants true/false, not the height.\nStep back to when you returned a number.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Bottom-up height; -1 if |l-r|>1 or a child already failed. Empty → true. O(n). Not Max Depth’s integer, not Convert-to-BST, not Validate BST, not Unique BST I.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
