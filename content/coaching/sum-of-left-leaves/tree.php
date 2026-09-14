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
            'message' => "Problem: binary tree, 1 to 1000 nodes, values −1000 to 1000. Return the sum of all left leaves. A leaf has no children. A left leaf is a leaf that is someone’s left child. [3,9,20,null,null,15,7] → 24 (9 and 15). [1] → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat this as Maximum Depth of Binary Tree (104), or add every left child even if it has descendants', 'next' => 'wrong_104'],
                ['label' => 'Recurse right always. Add the left child only when that child itself is a leaf', 'next' => 'dfs'],
            ],
        ],
        'wrong_104' => [
            'message' => "You are wrong here. 104 returns a height. Adding every left child would count internal nodes. 9 is a left leaf; 20 is a left-of-nothing internal node and must not be added just because it sits on the left of 3.\nStep back to when you used height or summed every left child.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "If root is null, return 0. ans starts as sumOfLeftLeaves(root.right). If root.left exists: when both of its children are missing, add root.left.val; else add sumOfLeftLeaves(root.left). The root of the whole tree is never a left leaf, so [1] is 0.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count the root as a left leaf, or skip the right subtree because right leaves never count', 'next' => 'wrong_root'],
                ['label' => 'Never add the root. Still recurse right: a right child can have left-leaf grandchildren', 'next' => 'kind'],
            ],
        ],
        'wrong_root' => [
            'message' => "You are wrong. A left leaf needs a parent that points left. Skipping the right subtree misses 15 under 20. 7 is a right leaf and stays out of the sum, but you still walk there to find left leaves below.\nStep back to when you counted the root or skipped the right walk.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'kind' => [
            'message' => "In the sample, 9 has no children (left of 3) and 15 has no children (left of 20), so 9+15=24. 7 is a right leaf. Time O(n), space O(n) for the call stack. Binary Tree Tilt (563) is a different parent-child abs-diff sum.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Add a left child only when it is a leaf. Recurse right always. [3,9,20,null,null,15,7] → 24. Not 104', 'next' => 'success'],
                ['label' => 'Sum every leaf, or every node on the left spine, including 7 or 20', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. Right leaves (7) do not count. Internal left children do not count. Only a left child with no children of its own.\nStep back to when you summed every leaf or the left spine.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Add a left child only when it is a leaf. Recurse the right subtree always. Single root → 0. Not 104.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
