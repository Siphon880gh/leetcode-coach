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
            'message' => "Problem: min depth is nodes on the shortest root-to-leaf path. A leaf has no children. [3,9,20,null,null,15,7] → 2. Skewed [2,null,3,null,4,null,5,null,6] → 5. Empty allowed.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Same as Max Depth: 1 + min(left, right) even when a child is missing', 'next' => 'max'],
                ['label' => 'If a child is None, recurse only on the other side; else 1 + min of both', 'next' => 'dfs'],
            ],
        ],
        'max' => [
            'message' => "1 + min(0, right) would call a node with one child a leaf. The skewed sample would return 1, not 5. A missing child is not a leaf.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Balanced Tree’s boolean, or Level Order nested lists', 'next' => 'wrong_bool'],
                ['label' => 'None → 0; only-left or only-right → 1 + that side; both kids → 1 + min', 'next' => 'dfs'],
            ],
        ],
        'wrong_bool' => [
            'message' => "You are wrong here.\nBalanced is true/false. Level Order is nested lists. This returns an integer depth.\nStep back to when you reused those problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'max',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "if root is None: 0. if left is None: 1 + minDepth(right). if right is None: 1 + minDepth(left). else 1 + min(both). Time O(n).\nWhy special-case a missing child?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'You must reach a node with two nulls; a one-child node is not a leaf', 'next' => 'ret'],
                ['label' => 'Empty children count as depth 0 so min can stop at the first null', 'next' => 'wrong_null'],
            ],
        ],
        'wrong_null' => [
            'message' => "You are wrong. Stopping at the first null is the Max-Depth-with-min bug. The note says a leaf has no children.\nStep back to when you treated null as a leaf.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return the integer. Empty tree is 0, not []. A single node is 1.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The shortest leaf depth in nodes, not a boolean and not Max Depth', 'next' => 'success'],
                ['label' => 'The longest path, like Maximum Depth of Binary Tree', 'next' => 'wrong_max'],
            ],
        ],
        'wrong_max' => [
            'message' => "You are wrong. Max Depth on the sample is 3; min depth is 2 because 9 is a nearer leaf.\nStep back to when you returned the longer path.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Null → 0. Skip a missing child. Both present → 1 + min. O(n). Not Max Depth, not Balanced’s boolean, not Level Order, not treating a one-child node as a leaf.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
