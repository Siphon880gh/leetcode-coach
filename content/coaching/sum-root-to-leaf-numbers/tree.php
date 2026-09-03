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
            'message' => "Problem: each root-to-leaf path is a decimal number; return their sum. [1,2,3] → 12+13=25. [4,9,0,5,1] → 495+491+40=1026. Digits 0-9, depth ≤ 10.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Path Sum I’s boolean, Path Sum II’s lists, or Max Path Sum’s bend through a node', 'next' => 'ps'],
                ['label' => 'DFS with a running value: s = s*10 + val; at a leaf return s; else add both children', 'next' => 'dfs'],
            ],
        ],
        'ps' => [
            'message' => "Path Sum I/II compare a running total to a target. Max Path Sum can turn left+node+right. Here 1-2 is the integer 12, not 3.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Min Depth’s shortest leaf, Flatten’s right spine, or Longest Consecutive’s hash set', 'next' => 'wrong_other'],
                ['label' => 'dfs(null)=0; s = s*10+val; if no children return s; return dfs(left,s)+dfs(right,s)', 'next' => 'dfs'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nThose problems do not fold digits into a base-10 number along a root-to-leaf path.\nStep back to when you copied them.",
            'outcome' => 'wrong',
            'rewind_to' => 'ps',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "A missing child returns 0, so a node with one child is not a leaf. Time O(n).\nWhy return s only when both children are null?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A leaf is a node with no children; a one-child node is still a prefix, not a finished number', 'next' => 'ret'],
                ['label' => 'If left is null, treat the node as a leaf and still recurse on the right', 'next' => 'wrong_leaf'],
            ],
        ],
        'wrong_leaf' => [
            'message' => "You are wrong. Counting 4 as 4 and also 40 would double-count. Only a node with no children closes a number.\nStep back to when you treated a one-child node as a leaf.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return the integer sum of those numbers, not the list of paths.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '25 and 1026 — not true/false, not [[1,2],[1,3]], not the max 13', 'next' => 'success'],
                ['label' => 'The path lists from Path Sum II, or only the largest number', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. The judge wants one integer: the sum of the decimal paths.\nStep back to when you returned lists or a max.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Carry s*10+val; add at a true leaf; null is 0. O(n). Not Path Sum I/II, not Max Path Sum, not Min Depth, not Flatten, not Longest Consecutive.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
