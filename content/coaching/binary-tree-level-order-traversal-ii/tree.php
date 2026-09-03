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
            'message' => "Problem: bottom-up level order, left to right on each row. [3,9,20,null,null,15,7] → [[15,7],[9,20],[3]]. Single node → [[1]]. Empty → []. Up to 2000 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return 102’s rows as-is, or zigzag reverse every other row', 'next' => 'top'],
                ['label' => 'Same BFS snapshot as 102, then reverse the list of rows', 'next' => 'bfs'],
            ],
        ],
        'top' => [
            'message' => "102 would give [[3],[9,20],[15,7]] — root first. Zigzag would shuffle left/right inside a row, not reverse the row order.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DFS inorder, or rebuild the tree like Construct from Postorder', 'next' => 'wrong_build'],
                ['label' => 'BFS: snapshot n = len(q) per level; after all rows, return ans[::-1]', 'next' => 'bfs'],
            ],
        ],
        'wrong_build' => [
            'message' => "You are wrong here.\nInorder emits one list. Construct builds a TreeNode. This returns nested value lists, leaf level first.\nStep back to when you rebuilt or inordered.",
            'outcome' => 'wrong',
            'rewind_to' => 'top',
            'choices' => [],
        ],
        'bfs' => [
            'message' => "If root is None, []. Else q = deque([root]). For each level, t = []; loop n = len(q): popleft, append val, enqueue left then right. ans.append(t). Time O(n).\nWhy reverse after the loop, not each row?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Each row stays left-to-right; only the order of rows flips (leaf to root)', 'next' => 'ret'],
                ['label' => 'Reverse t before append so [15,7] becomes [7,15] like zigzag', 'next' => 'wrong_zig'],
            ],
        ],
        'wrong_zig' => [
            'message' => "You are wrong. The sample’s first row is [15,7], left then right. Reversing inside the row is Zigzag Level Order, a different problem.\nStep back to when you reversed a row.",
            'outcome' => 'wrong',
            'rewind_to' => 'bfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return ans[::-1]. Empty tree stays []. [1] stays [[1]].\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The reversed nested lists, not a boolean or a rebuilt tree', 'next' => 'success'],
                ['label' => 'A single flat list [15,7,9,20,3]', 'next' => 'wrong_flat'],
            ],
        ],
        'wrong_flat' => [
            'message' => "You are wrong. The judge wants a list of levels, not one flattened traversal.\nStep back to when you flattened.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. BFS with a per-level snapshot, left then right, then reverse the rows. Empty → []. O(n). Not 102’s top-down lists, not zigzag, not inorder, not Construct Tree.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
