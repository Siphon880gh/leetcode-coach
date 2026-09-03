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
            'message' => "Problem: true iff some root-to-leaf path sums to targetSum. [5,4,8,11,null,13,4,7,2,null,null,null,1], 22 → true. [1,2,3], 5 → false. Empty, 0 → false. Up to 5000 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return Min Depth’s integer, or Unique Paths counting grid walks', 'next' => 'depth'],
                ['label' => 'DFS: add the node’s val; at a leaf, compare the running sum to the target', 'next' => 'dfs'],
            ],
        ],
        'depth' => [
            'message' => "Min Depth is a count of nodes. Unique Paths counts grid routes. This is a boolean on path values, and a leaf has no children.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Empty tree with target 0 is true, because 0 equals the target', 'next' => 'wrong_empty'],
                ['label' => 'dfs(None, s) is False; leaf with s+val == target is True; else OR the two children', 'next' => 'dfs'],
            ],
        ],
        'wrong_empty' => [
            'message' => "You are wrong here.\nExample 3: empty tree has no root-to-leaf path, so false even when targetSum is 0.\nStep back to when you treated empty as a match.",
            'outcome' => 'wrong',
            'rewind_to' => 'depth',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "dfs(root, 0): if root is None, False. s += val. If both children None and s == targetSum, True. Return dfs(left, s) or dfs(right, s). Time O(n).\nWhy wait for a leaf instead of matching any node?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The problem requires a root-to-leaf path, not a prefix that happens to equal the target', 'next' => 'ret'],
                ['label' => 'Match as soon as the running sum hits the target, even mid-path', 'next' => 'wrong_mid'],
            ],
        ],
        'wrong_mid' => [
            'message' => "You are wrong. A prefix sum can hit 22 before the leaf and still fail if you stop early, or succeed later. Only a leaf decides.\nStep back to when you matched a non-leaf.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return the boolean from dfs(root, 0). Not a list of paths (that is Path Sum II).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'true or false: whether any leaf path equals the target', 'next' => 'success'],
                ['label' => 'Every matching path as nested lists, like Path Sum II', 'next' => 'wrong_ii'],
            ],
        ],
        'wrong_ii' => [
            'message' => "You are wrong. Path Sum II collects every path. This problem only asks whether one exists.\nStep back to when you listed paths.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. DFS with a running sum; succeed only at a leaf. Empty → false. O(n). Not Min/Max Depth, not Unique Paths, not Path Sum II, not matching a non-leaf prefix.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
