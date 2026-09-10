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
            'message' => "Problem: inorder successor of p in a BST — the node with the smallest key greater than p.val, or null. [2,1,3], p = 1 → 2. p = 6 in a tree whose max is 6 → null. Unique values.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Dump the whole inorder list, then scan for p and take the next entry', 'next' => 'wrong_dump'],
                ['label' => 'Walk from root: candidate when greater than p, then hunt left', 'next' => 'walk'],
            ],
        ],
        'wrong_dump' => [
            'message' => "You are wrong here.\nAn inorder array is O(n) extra and slower than a BST walk. Use the search path.\nStep back to when you materialized the full inorder list.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'walk' => [
            'message' => "ans = null. While root: if root.val > p.val, ans = root and go left (a smaller key may still beat p). Else go right. Last ans is the tightest upper bound. If p has a right child, this lands on the leftmost node of that subtree.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the first node greater than p on a preorder walk', 'next' => 'wrong_pre'],
                ['label' => 'O(h) time, O(1) extra. Return the node, not just the value', 'next' => 'cpx'],
            ],
        ],
        'wrong_pre' => [
            'message' => "You are wrong. Preorder’s first greater node may not be the smallest greater. The successor is the tightest upper bound, which the left-hunt finds.\nStep back to when you used preorder.",
            'outcome' => 'wrong',
            'rewind_to' => 'walk',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(h), O(1). This is 285 (no parent pointers). 510 (BST II) uses parents.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Candidate when greater, then left. Not full inorder, not preorder, not always p’s parent', 'next' => 'success'],
                ['label' => 'p’s parent is always the successor', 'next' => 'wrong_parent'],
            ],
        ],
        'wrong_parent' => [
            'message' => "You are wrong. Parent is the successor only in some shapes (1 under 2). If p has a right subtree, the successor is the min of that subtree, not the parent.\nStep back to when you always returned the parent.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Walk from the root. Greater than p → remember and go left; else go right. Last candidate is the successor, or null. O(h), no inorder dump.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
