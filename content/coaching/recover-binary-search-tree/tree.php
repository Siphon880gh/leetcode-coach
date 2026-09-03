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
            'message' => "Problem: exactly two nodes in a BST had their values swapped. Recover it in place; do not change structure. [1,3,null,null,2] → swap 1 and 3. [3,1,4,null,null,2] → swap 3 and 2. Nodes 2..1000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return a boolean like Validate BST, or rebuild a new tree like Unique BST II', 'next' => 'validate'],
                ['label' => 'Inorder: find the two inversion pairs, then swap those two node values', 'next' => 'dfs'],
            ],
        ],
        'validate' => [
            'message' => "Validate BST only answers yes/no. Unique BST II builds every shape from 1..n. Here the shape is already correct; two values sit in the wrong nodes.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort all values and attach a brand-new left/right structure', 'next' => 'wrong_rebuild'],
                ['label' => 'Inorder is almost sorted: one or two drops. Record first and second, then swap .val', 'next' => 'dfs'],
            ],
        ],
        'wrong_rebuild' => [
            'message' => "You are wrong here.\nThe follow-up wants the same pointers. Writing values onto the existing inorder walk is enough; do not allocate a new tree.\nStep back to when you rebuilt the shape.",
            'outcome' => 'wrong',
            'rewind_to' => 'validate',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Walk left, then: if prev and prev.val > root.val, set first = prev on the first drop, and always set second = root. Then prev = root, walk right. Adjacent swap → one drop; far swap → two drops (first stays the earlier high, second becomes the later low).\nWhy keep updating second on every drop?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The second swapped node is the last inorder value that is too small', 'next' => 'ret'],
                ['label' => 'Swap every inverted adjacent pair on the fly, like Sort Colors in one pass', 'next' => 'wrong_each'],
            ],
        ],
        'wrong_each' => [
            'message' => "You are wrong. Two far-apart swaps make two drops that are not a single adjacent pair. You must remember both endpoints, then swap once.\nStep back to when you swapped each drop immediately.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "After dfs, swap first.val and second.val. The function is void.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Nothing — mutate the two nodes, keep the same structure', 'next' => 'success'],
                ['label' => 'True/false like Validate BST', 'next' => 'wrong_bool'],
            ],
        ],
        'wrong_bool' => [
            'message' => "You are wrong. Validate BST returns a boolean. Recover returns nothing and edits values in place.\nStep back to when you returned true/false.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Inorder, record first (prev of the first drop) and second (root of the last drop), then swap those two values. O(n). Not Validate BST’s boolean, not Unique BST II’s new trees, not rebuilding pointers.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
