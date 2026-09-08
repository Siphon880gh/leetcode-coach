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
            'message' => "Problem: complete binary tree (last level packed left). Return the node count in better than O(n). Empty → 0. [1,2,3,4,5,6] → 6. [1] → 1. Up to 5 × 10⁴ nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '1 + count(left) + count(right) on every node, or 2^h − 1 as if the whole tree were perfect', 'next' => 'naive'],
                ['label' => 'Compare left-spine heights of the children; add 1 << height of the perfect half; recurse the other', 'next' => 'half'],
            ],
        ],
        'naive' => [
            'message' => "Full recurse is O(n) and misses the follow-up. A complete tree is not always perfect: [1,2,3,4,5,6] is not 7 nodes. Maximum Depth / Right Side View walk for a different answer.\nHow do you skip a half?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Height = left-spine length. hl==hr → left is perfect, add 1<<hl, recurse right. Else add 1<<hr, recurse left', 'next' => 'half'],
                ['label' => 'BFS every node and increment a counter', 'next' => 'wrong_bfs'],
            ],
        ],
        'wrong_bfs' => [
            'message' => "You are wrong here.\nVisiting every node is still O(n).\nStep back to when you BFS-ed the whole tree.",
            'outcome' => 'wrong',
            'rewind_to' => 'naive',
            'choices' => [],
        ],
        'half' => [
            'message' => "depth walks only .left. If heights match, left subtree plus the root is 2^{hl} nodes (that is 1 shifted left hl). Recurse only the incomplete side. Empty root is 0.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[] → 0; [1] → 1; [1,2,3,4,5,6] → 6 (not 7)', 'next' => 'cpx'],
                ['label' => '[1,2,3,4,5,6] is a perfect tree of height 3, so the answer is 7', 'next' => 'wrong_perf'],
            ],
        ],
        'wrong_perf' => [
            'message' => "You are wrong. Completeness is not perfection. The last level is missing a node, so 6 not 7.\nStep back to when you treated the whole tree as perfect.",
            'outcome' => 'wrong',
            'rewind_to' => 'half',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Each call O(log n) for two spines, then drops a perfect half: O((log n)²) time, O(log n) recursion.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Perfect-half shortcut; not O(n) both children, not 2^h−1 on the whole tree, not BFS count', 'next' => 'success'],
                ['label' => 'Always recurse both children; the height test is only for printing', 'next' => 'wrong_both'],
            ],
        ],
        'wrong_both' => [
            'message' => "You are wrong. Recursing both sides again is the O(n) walk. You skip the perfect half.\nStep back to when you ignored the shortcut.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Left-spine heights. Equal → add 1<<hl, count the right. Else add 1<<hr, count the left. O((log n)²). Not O(n), not whole-tree 2^h−1, not BFS.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
