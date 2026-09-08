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
            'message' => "Problem: values you would see standing on the right, top to bottom. [1,2,3,null,5,null,4] → [1,3,4]. [1,2,3,4,null,null,null,5] → [1,3,4,5]. Empty → []. Up to 100 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Walk only the right spine (root, right, right, …) or dump every level like Level Order', 'next' => 'spine'],
                ['label' => 'Rightmost node of each depth: BFS last-of-level, or DFS right-first first-at-depth', 'next' => 'view'],
            ],
        ],
        'spine' => [
            'message' => "The second sample’s 4 and 5 sit on the left but are still visible. Level Order would return nested rows, not one value per depth.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'House Robber: skip-or-take DP on a line of houses', 'next' => 'wrong_rob'],
                ['label' => 'One value per depth: the rightmost node, even if it lives in a left subtree', 'next' => 'view'],
            ],
        ],
        'wrong_rob' => [
            'message' => "You are wrong here.\nHouse Robber is 1D DP on an array. This returns a list of tree values.\nStep back to when you reused House Robber.",
            'outcome' => 'wrong',
            'rewind_to' => 'spine',
            'choices' => [],
        ],
        'view' => [
            'message' => "BFS: enqueue right then left so the front of each level is the rightmost; record it, then drain the snapshot. Or enqueue left then right and take the last node of the snapshot. DFS: visit right, then left; when depth equals len(ans), append.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,2,3,4,null,null,null,5] is [1,3,4,5], not [1,3] from the right spine', 'next' => 'cpx'],
                ['label' => '[1,2,3,4,null,null,null,5] is [1,3] or Level Order [[1],[2,3],[4],[5]]', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. Depths 2 and 3 still have a visible node (4 then 5). Level Order keeps every sibling; this keeps one per depth.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'view',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n). Space O(n) for the queue or the recursion stack. Empty root returns [].\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Rightmost per depth; not the right spine, not full Level Order rows', 'next' => 'success'],
                ['label' => 'Inorder left-visit-right already is the right-side list', 'next' => 'wrong_inorder'],
            ],
        ],
        'wrong_inorder' => [
            'message' => "You are wrong. Inorder mixes depths. Right-side view is one node per depth, top to bottom.\nStep back to when you used inorder.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Rightmost node of each depth. BFS last-of-level or DFS right-first. O(n) / O(n). Not the right spine, not Level Order’s nested rows, not House Robber, not inorder.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
