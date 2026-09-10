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
            'message' => "Problem: largest subtree that is a BST, by node count. Subtree includes every descendant. [10,5,15,1,8,null,7] → 3 (the 5 / 1, 8 side). Empty → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Validate BST (98) on the whole tree, or return the subtree root', 'next' => 'wrong_98'],
                ['label' => 'Post-order: each node returns (min, max, size) or a poison range', 'next' => 'dfs'],
            ],
        ],
        'wrong_98' => [
            'message' => "You are wrong here. The whole tree may fail BST while a smaller subtree is valid. The judge wants the size, not a pointer to the root.\nStep back to when you ran 98 on the whole tree or returned a node.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Null is (+inf, −inf, 0) so a missing child never blocks left.max < val < right.min. If both sides are BSTs and that inequality holds, size is left.size + right.size + 1. Else return (−inf, +inf, 0) so ancestors cannot grow through this node. Track a global max size.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Check only immediate children, or add sizes from a poisoned child', 'next' => 'wrong_local'],
                ['label' => 'O(n) one pass; poison size is 0', 'next' => 'cpx'],
            ],
        ],
        'wrong_local' => [
            'message' => "You are wrong. Far descendants can still break BST. Poisoned children report size 0; summing them as if they were valid inflates the answer.\nStep back to when you used a local check or added poisoned sizes.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Follow-up is O(n). Recursion depth is the height.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Bottom-up min, max, size. Not 98 on the whole tree', 'next' => 'success'],
                ['label' => 'Return the largest BST root instead of its node count', 'next' => 'wrong_root'],
            ],
        ],
        'wrong_root' => [
            'message' => "You are wrong. The return value is the number of nodes, not a TreeNode.\nStep back to when you returned a root.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Post-order (min, max, size); poison on failure. Null is (+inf, −inf, 0). Not Validate BST on the whole tree.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
