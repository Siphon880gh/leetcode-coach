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
            'message' => "Problem: is this binary tree a BST? [2,1,3] → true. [5,1,4,null,null,3,6] → false (4 sits right of 5). Nodes 1..10^4. Values may be INT_MIN.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only check left.val < node.val < right.val on each node, or Unique BST I’s Catalan count', 'next' => 'local'],
                ['label' => 'Inorder DFS: left, then compare this value to prev, then right', 'next' => 'dfs'],
            ],
        ],
        'local' => [
            'message' => "A local child check misses a far descendant: 3 can sit in 5’s right subtree under 6 and still look fine next to 6. Unique BST I counts shapes; this returns a boolean on one tree.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'BFS level order, like Unique Paths walking a grid', 'next' => 'wrong_bfs'],
                ['label' => 'Inorder of a BST is strictly increasing — keep prev, reject prev ≥ val', 'next' => 'dfs'],
            ],
        ],
        'wrong_bfs' => [
            'message' => "You are wrong here.\nLevel order does not encode BST order. Inorder does.\nStep back to when you reused BFS or Unique Paths.",
            'outcome' => 'wrong',
            'rewind_to' => 'local',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Null is valid. After left, if prev ≥ root.val return false; then prev = root.val; then right. Start prev at -∞, not INT_MIN (a node may hold INT_MIN). Time O(n).\nWhy strictly greater, not ≥?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The BST definition forbids equal keys — duplicates fail', 'next' => 'ret'],
                ['label' => 'Allow equals like Remove Duplicates keeping one copy', 'next' => 'wrong_dup'],
            ],
        ],
        'wrong_dup' => [
            'message' => "You are wrong. This BST is strict: left keys < node, right keys > node. Equal neighbors are invalid.\nStep back to when you allowed duplicates.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return the boolean from dfs(root). Not the inorder list, not a repaired tree.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'True iff the whole inorder walk stayed strictly increasing', 'next' => 'success'],
                ['label' => 'The inorder values, like Binary Tree Inorder Traversal', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. Inorder Traversal returns the values. This problem only asks whether they would be strictly sorted.\nStep back to when you returned the list.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Inorder with prev starting at -∞. Reject prev ≥ val. O(n). Not a local child check, not Unique BST counts, not the inorder list, not BFS.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
