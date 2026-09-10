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
            'message' => "Problem: invert the binary tree (swap every left/right pair) and return the root. [4,2,7,1,3,6,9] → [4,7,2,9,6,3,1]. [2,1,3] → [2,3,1]. Empty → empty. Up to 100 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Symmetric Tree (only check a mirror) or Same Tree (same-side pairing)', 'next' => 'check'],
                ['label' => 'Save invert(left) and invert(right), then assign left = rightResult and right = leftResult', 'next' => 'swap'],
            ],
        ],
        'check' => [
            'message' => "Symmetric Tree returns a boolean. Same Tree does not mutate. You still visit every node; Count Complete Tree Nodes’ perfect-half skip does not apply.\nHow do you invert?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Recurse both children into locals, then swap. Or swap first, then invert each. BFS swap per node is the same', 'next' => 'swap'],
                ['label' => 'root.left = invert(root.right) without saving the original left', 'next' => 'wrong_save'],
            ],
        ],
        'wrong_save' => [
            'message' => "You are wrong here.\nThat overwrite drops the original left before you invert it.\nStep back to when you clobbered left.",
            'outcome' => 'wrong',
            'rewind_to' => 'check',
            'choices' => [],
        ],
        'swap' => [
            'message' => "Null returns null. Return the same root after the swap. In-place is the usual write-up. Swap only at the root is not enough.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[4,2,7,1,3,6,9] → [4,7,2,9,6,3,1]; [2,1,3] → [2,3,1]; empty stays empty', 'next' => 'cpx'],
                ['label' => 'Only swap the root’s two children; leave the rest', 'next' => 'wrong_root'],
            ],
        ],
        'wrong_root' => [
            'message' => "You are wrong. Every node needs the swap. [4,2,7,1,3,6,9] would stay [4,7,2,1,3,6,9] if you stop at the root.\nStep back to when you inverted only the root.",
            'outcome' => 'wrong',
            'rewind_to' => 'swap',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(n) recursion or queue. Mutate, do not only check symmetry.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Swap at every node (save both first); not Symmetric Tree, not Same Tree, not root-only', 'next' => 'success'],
                ['label' => 'Return true/false like Symmetric Tree', 'next' => 'wrong_bool'],
            ],
        ],
        'wrong_bool' => [
            'message' => "You are wrong. The judge wants the inverted root, not a boolean.\nStep back to when you returned a check.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Recurse (or BFS) and swap left/right at every node. Save both children first. O(n). Not a symmetry check, not Same Tree, not clobbering left, not root-only.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
