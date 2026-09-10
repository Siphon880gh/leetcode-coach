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
            'message' => "Problem: longest consecutive path in a binary tree. Values increase by 1, parent to child only (no walking up). May start at any node. [1,null,3,2,4,null,null,null,5] → 3 (3-4-5). [2,null,3,2,null,1] → 2 (2-3, not 3-2-1).\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat it as array LCS (128) or allow up-and-down through a node (549)', 'next' => 'wrong_kind'],
                ['label' => 'DFS: run starts at this node; reset unless child is plus one', 'next' => 'dfs'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong here.\n128 is an unordered array. 549 lets a path go both ways through a node. Here you only go down, and only child == parent + 1.\nStep back to when you reused 128 or 549.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "dfs returns the longest downward run starting here. Recurse children. l = dfs(left)+1, then if left exists and left.val − node.val != 1, l = 1. Same for right. t = max(l, r); update global ans; return t so the parent can extend.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count decreasing 3-2-1, or walk to the parent', 'next' => 'wrong_dec'],
                ['label' => 'O(n) time, O(h) recursion. Global max of every node run', 'next' => 'cpx'],
            ],
        ],
        'wrong_dec' => [
            'message' => "You are wrong. The path must increase by one downward. 3-2-1 is not consecutive here.\nStep back to when you counted a decrease or walked up.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Skipping a value (1 then 3) resets. A single node is length 1.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Downward plus-one only. Not 128, not 549, not 3-2-1', 'next' => 'success'],
                ['label' => 'Any strictly increasing child extends, even if the gap is 2', 'next' => 'wrong_skip'],
            ],
        ],
        'wrong_skip' => [
            'message' => "You are wrong. The child must be exactly parent + 1. A gap of 2 starts a new run of 1.\nStep back to when you allowed skips.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. DFS returns the downward plus-one run at this node. Reset when the child is not next. Track a global max. 3-4-5 is 3; 3-2-1 is not. O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
