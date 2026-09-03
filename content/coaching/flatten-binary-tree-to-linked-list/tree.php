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
            'message' => "Problem: flatten in place into a preorder “linked list”: right is next, left is always None. [1,2,5,3,4,null,6] → [1,null,2,null,3,null,4,null,5,null,6]. Void. Up to 2000 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return Path Sum II’s lists of values, or build a new ListNode chain', 'next' => 'vals'],
                ['label' => 'Walk nodes: if left exists, hang the old right off the left subtree’s rightmost, then move left to right', 'next' => 'pred'],
            ],
        ],
        'vals' => [
            'message' => "Path Sum II copies values. This rewires the same TreeNodes. A new ListNode chain would not use left/right of TreeNode.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Inorder (left, visit, right), or Unique BST II generating trees', 'next' => 'wrong_in'],
                ['label' => 'while root: find predecessor on the left; pre.right = root.right; root.right = root.left; left = None; step right', 'next' => 'pred'],
            ],
        ],
        'wrong_in' => [
            'message' => "You are wrong here.\nThe required order is preorder (root, left, right), not inorder. Unique BST II builds many trees; this mutates one.\nStep back to when you used inorder or Unique BST II.",
            'outcome' => 'wrong',
            'rewind_to' => 'vals',
            'choices' => [],
        ],
        'pred' => [
            'message' => "If there is no left, just root = root.right. Time O(n), extra space O(1).\nWhy attach the old right to the left subtree’s rightmost node?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Preorder finishes the left subtree, then the original right; that rightmost is the join point', 'next' => 'ret'],
                ['label' => 'Attach to the leftmost so the list follows inorder', 'next' => 'wrong_left'],
            ],
        ],
        'wrong_left' => [
            'message' => "You are wrong. Leftmost would scramble preorder. The last node visited in the left subtree is its rightmost.\nStep back to when you joined at the leftmost.",
            'outcome' => 'wrong',
            'rewind_to' => 'pred',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Modify root in place. Empty stays empty. Do not return a new head.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Nothing (None); the flattened spine is already on root.right', 'next' => 'success'],
                ['label' => 'A boolean like Path Sum, or nested level lists', 'next' => 'wrong_ret'],
            ],
        ],
        'wrong_ret' => [
            'message' => "You are wrong. The signature is void. The judge inspects the mutated tree.\nStep back to when you returned a value.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Predecessor on the left; splice old right; move left to right; clear left; walk right. O(n) / O(1). Not Path Sum II, not inorder, not Unique BST II, not a new ListNode chain.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
