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
            'message' => "Problem: sorted singly linked list → height-balanced BST. [-10,-3,0,5,9] accepts [0,-3,9,-10,null,5]. Empty head → []. Up to 2·10^4 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Index the list like 108’s nums[mid] without converting', 'next' => 'idx'],
                ['label' => 'Walk the list into an array, then reuse 108’s mid-of-slice recursion', 'next' => 'arr'],
            ],
        ],
        'idx' => [
            'message' => "A ListNode has .next, not random access. nums[mid] is O(1) only after you copy values into an array.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Unique BST II generating every Catalan shape, or Level Order BFS', 'next' => 'wrong_enum'],
                ['label' => 'While head: nums.append(head.val); then dfs(i, j) with mid = (i+j)>>1', 'next' => 'arr'],
            ],
        ],
        'wrong_enum' => [
            'message' => "You are wrong here.\nUnique BST II enumerates trees. Level Order lists rows. This builds one BST from a given list.\nStep back to when you reused those problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'idx',
            'choices' => [],
        ],
        'arr' => [
            'message' => "dfs: if i > j, None. mid = (i+j)>>1; left = dfs(i, mid-1); right = dfs(mid+1, j); return TreeNode(nums[mid], left, right). Time O(n).\nWhy copy the list instead of always taking head as root?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always using the list head makes a right spine, not height-balanced', 'next' => 'ret'],
                ['label' => 'The judge only checks BST order, so a chain is fine', 'next' => 'wrong_height'],
            ],
        ],
        'wrong_height' => [
            'message' => "You are wrong. Same as 108: the tree must be height-balanced, not merely a valid BST chain.\nStep back to when you ignored height.",
            'outcome' => 'wrong',
            'rewind_to' => 'arr',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return dfs(0, len(nums)-1). Empty list: nums is [], i=0 > j=-1 → None.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The constructed root, not nested level lists and not a Catalan count', 'next' => 'success'],
                ['label' => 'The nums array itself, like Binary Tree Inorder Traversal', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. nums is only an intermediate. The output is a tree.\nStep back to when you returned the array.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Copy the list to an array, then mid-of-slice DFS like 108. Empty → None. O(n). Not 108’s already-an-array input, not Unique BST I/II, not Level Order, not a linked-list spine.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
