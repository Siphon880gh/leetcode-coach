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
            'message' => "Problem: binary tree of houses. Parent and child cannot both be robbed. [3,2,3,null,3,null,1] → 7. [3,4,5,1,3,null,1] → 9. Up to 1e4 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'House Robber (198) on a line, or rob every other level as a block', 'next' => 'wrong_198'],
                ['label' => 'Post-order pair: (take this node, skip this node)', 'next' => 'dfs'],
            ],
        ],
        'wrong_198' => [
            'message' => "You are wrong here. 198 is a path, not a tree. Taking a whole level misses a rich child that beats its parent, or two grandchildren that beat one parent.\nStep back to when you flattened the tree or robbed by level.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "dfs returns (take, skip). take = val plus skip of both children. skip = better of take/skip on the left plus better of take/skip on the right. Null is (0, 0). Answer is the better of the two at the root.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'When taking the node, still add a child take (adjacent rob)', 'next' => 'wrong_adj'],
                ['label' => 'O(n) one post-order; children are independent on skip', 'next' => 'cpx'],
            ],
        ],
        'wrong_adj' => [
            'message' => "You are wrong. If you rob this node, both children must be skipped. You may still take grandchildren through those skip values.\nStep back to when you robbed a parent and a child together.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Space is the recursion height (O(n) worst case).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'take = val + skip children; skip = max of each child. Not 198', 'next' => 'success'],
                ['label' => 'Return only the take value at the root', 'next' => 'wrong_only'],
            ],
        ],
        'wrong_only' => [
            'message' => "You are wrong. Skipping the root can be better (example 2: 4+5 beats taking 3).\nStep back to when you ignored the skip option at the root.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Post-order (take, skip). take uses child skips; skip uses the better of each child. Not 198 on a line.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
