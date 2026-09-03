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
            'message' => "Problem: max sum of any non-empty path (need not pass the root). [1,2,3] → 6 (2-1-3). [-10,9,20,null,null,15,7] → 42 (15-20-7). Node values can be negative.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Path Sum I (boolean to a target) or Path Sum II (all root-to-leaf lists)', 'next' => 'ps'],
                ['label' => 'DFS: each node updates a global with left+val+right, then returns val + the better child', 'next' => 'dfs'],
            ],
        ],
        'ps' => [
            'message' => "Path Sum I/II start at the root and stop at a leaf. Here a path may bend through a node and skip the root entirely.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Max Depth’s height, Flatten’s preorder spine, or Triangle’s grid min', 'next' => 'wrong_other'],
                ['label' => 'left = max(0, dfs(left)); right = max(0, dfs(right)); ans = max(ans, val+left+right); return val+max(left, right)', 'next' => 'dfs'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nHeight, flatten, and Triangle do not pick a max-sum path that can turn at a node.\nStep back to when you copied those problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'ps',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Clamp a negative child to 0 so you drop it. The value returned to the parent uses only one child, because a parent cannot attach to both sides.\nWhy start ans at -inf, not 0?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A tree of one node -3 must return -3, not 0; empty is not allowed', 'next' => 'ret'],
                ['label' => 'Empty path is allowed, so 0 is a legal answer on all-negative trees', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. The path is non-empty. If every node is negative, the answer is the largest (least negative) node.\nStep back to when you initialized ans to 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return the global ans after dfs(root), not the number dfs itself returns.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The integer 6 or 42, not a boolean, not a list of nodes, not dfs(root)’s one-sided gain', 'next' => 'success'],
                ['label' => 'return dfs(root), since that is already the max path', 'next' => 'wrong_gain'],
            ],
        ],
        'wrong_gain' => [
            'message' => "You are wrong. dfs returns only the best chain going up. The bend 2-1-3 lives in the global, not in that return value.\nStep back to when you returned the dfs gain.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Clamp negative children. Update ans with both sides; return one side. Init ans to -inf. O(n). Not Path Sum I/II, not Max Depth, not Flatten, not Triangle.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
