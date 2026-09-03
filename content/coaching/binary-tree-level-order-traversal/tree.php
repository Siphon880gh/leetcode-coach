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
            'message' => "Problem: return values level by level, left to right. [3,9,20,null,null,15,7] → [[3],[9,20],[15,7]]. Single node → [[1]]. Empty → []. Up to 2000 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Inorder DFS (left, visit, right), or Same Tree pairing two roots', 'next' => 'dfs'],
                ['label' => 'BFS queue: drain exactly the current size, collect vals, enqueue left then right', 'next' => 'bfs'],
            ],
        ],
        'dfs' => [
            'message' => "Inorder would mix levels ([9,3,15,20,7]). Same Tree compares two trees. Level order groups by depth.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Unique Paths: count down-or-right grid walks', 'next' => 'wrong_paths'],
                ['label' => 'While the queue is nonempty, snapshot n = len(q) and process those n nodes as one row', 'next' => 'bfs'],
            ],
        ],
        'wrong_paths' => [
            'message' => "You are wrong here.\nUnique Paths counts routes on a grid. This returns nested lists of tree values.\nStep back to when you reused Unique Paths.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'bfs' => [
            'message' => "If root is None, return []. Else q = deque([root]). For each level, t = []; loop n times: popleft, append val, enqueue existing left then right. Then ans.append(t). Time O(n).\nWhy snapshot n before the inner loop?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Children join the queue during the loop; n is the count that belonged to this level only', 'next' => 'ret'],
                ['label' => 'Process until the queue is empty in one inner loop — one flat list like inorder', 'next' => 'wrong_flat'],
            ],
        ],
        'wrong_flat' => [
            'message' => "You are wrong. Draining the whole queue in one pass flattens the tree. The sample needs three inner lists, not [3,9,20,15,7].\nStep back to when you flattened the levels.",
            'outcome' => 'wrong',
            'rewind_to' => 'bfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return ans, a list of levels. Not a boolean, not a rebuilt tree.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The nested level lists; empty tree is [] not [[]]', 'next' => 'success'],
                ['label' => 'Zigzag alternating left-right then right-left on each row', 'next' => 'wrong_zig'],
            ],
        ],
        'wrong_zig' => [
            'message' => "You are wrong. Zigzag Level Order is a later problem. This one is strictly left to right on every level.\nStep back to when you zigzagged.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. BFS; snapshot the queue length per level; left then right. Empty → []. O(n). Not inorder, not Same Tree, not Unique Paths, not zigzag.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
