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
            'message' => "Problem: maximum depth — nodes on the longest root-to-leaf path. [3,9,20,null,null,15,7] → 3. [1,null,2] → 2. Empty is allowed (0 nodes).\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return Level Order’s nested lists, or Unique Paths counting grid walks', 'next' => 'lists'],
                ['label' => 'If None return 0; else 1 + max(depth(left), depth(right))', 'next' => 'dfs'],
            ],
        ],
        'lists' => [
            'message' => "Level Order returns [[3],[9,20],[15,7]]; depth is the number of those rows, not the lists. Unique Paths counts routes on a grid.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count every node like n, the size of the tree', 'next' => 'wrong_count'],
                ['label' => 'Recurse both children; the depth is one plus the deeper subtree', 'next' => 'dfs'],
            ],
        ],
        'wrong_count' => [
            'message' => "You are wrong here.\nA tree of five nodes can have depth 3. Depth is the longest path, not |V|.\nStep back to when you counted all nodes.",
            'outcome' => 'wrong',
            'rewind_to' => 'lists',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Null → 0 so a missing child adds nothing. Time O(n) — each node once.\nWhy 1 + max, not max alone?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The current node is on the path; the problem counts nodes, not edges', 'next' => 'ret'],
                ['label' => 'Return max(l, r) only — a single node would be 0', 'next' => 'wrong_edge'],
            ],
        ],
        'wrong_edge' => [
            'message' => "You are wrong. [1] must return 1. Dropping the +1 counts edges and fails the empty/leaf base.\nStep back to when you omitted the current node.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return an integer. Empty tree → 0, not [].\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The height in nodes along the longest path', 'next' => 'success'],
                ['label' => 'A boolean like Same Tree or Symmetric Tree', 'next' => 'wrong_bool'],
            ],
        ],
        'wrong_bool' => [
            'message' => "You are wrong. Same Tree and Symmetric Tree return booleans. This returns a count.\nStep back to when you returned true/false.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Null → 0. Else 1 + max of the two children. O(n). Not Level Order lists, not Unique Paths, not |V|, not a boolean.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
