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
            'message' => "Problem: collect all current leaves, remove them, repeat until the tree is empty. Return those waves. [1,2,3,4,5] → [[4,5,3],[2],[1]] (order inside a wave does not matter). Single node → [[1]]. Up to 100 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'BFS from the root and group by depth (level order, maybe reversed like 107)', 'next' => 'wrong_level'],
                ['label' => 'Post-order height from the leaves: a leaf is 0, parent is 1 + max of children. Push val into ans[h]', 'next' => 'height'],
            ],
        ],
        'wrong_level' => [
            'message' => "You are wrong here. Root-to-leaf levels would put 1 with 2 and 3. Wave 0 must be the true leaves 4, 5, and 3.\nStep back to when you grouped by depth from the root.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'height' => [
            'message' => "dfs(null) returns 0. h = max(left, right). If ans has length h, append a new wave. ans[h].append(val). Return h+1 so the parent sits one wave later. One DFS simulates every strip without mutating the tree.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Loop “find all leaves, delete, repeat” as separate full-tree scans for each wave', 'next' => 'wrong_scan'],
                ['label' => 'One O(n) DFS is enough. Wave 0 true leaves, then what would be leaves after those are gone', 'next' => 'kind'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong. Repeated O(n) strip passes work on 100 nodes but hide the height invariant. The post-order already knows every wave.\nStep back to when you stripped the tree in many scans.",
            'outcome' => 'wrong',
            'rewind_to' => 'height',
            'choices' => [],
        ],
        'kind' => [
            'message' => "107 groups bottom-up by depth from the root, a different partition. Order inside a wave may vary. The original root is always the last wave.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Height from leaves, ans[h]. Not 107, not mutating strip loops', 'next' => 'success'],
                ['label' => 'Require left-to-right order inside each wave, or put the root in wave 0', 'next' => 'wrong_order'],
            ],
        ],
        'wrong_order' => [
            'message' => "You are wrong. The problem allows any order inside a wave. The root is last, not first.\nStep back to when you over-constrained order or put the root in wave 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Height from the leaves: leaf 0, parent 1 + max of children. [1,2,3,4,5] → [[4,5,3],[2],[1]]. Not level order from the root.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
