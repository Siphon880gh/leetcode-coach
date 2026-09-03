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
            'message' => "Problem: nums is strictly increasing; convert it to a height-balanced BST. [-10,-3,0,5,9] accepts [0,-3,9,-10,null,5]. Length 1..10^4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Unique BST II: generate every Catalan tree on 1..n', 'next' => 'all'],
                ['label' => 'Pick the middle of the current slice as root so left and right stay balanced', 'next' => 'dfs'],
            ],
        ],
        'all' => [
            'message' => "Unique BST II enumerates every shape. Here nums is given; you need one balanced tree whose inorder is nums.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'BFS Level Order, or Construct from inorder+postorder', 'next' => 'wrong_trav'],
                ['label' => 'dfs(l, r): if l > r, None; mid = (l+r)>>1; TreeNode(nums[mid], left slice, right slice)', 'next' => 'dfs'],
            ],
        ],
        'wrong_trav' => [
            'message' => "You are wrong here.\nLevel Order lists rows. Construct 106 rebuilds from two traversals. This builds from one sorted array.\nStep back to when you reused a traversal problem.",
            'outcome' => 'wrong',
            'rewind_to' => 'all',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Return dfs(0, n-1). Left is dfs(l, mid-1), right is dfs(mid+1, r). Time O(n); recursion depth O(log n).\nWhy the middle, not nums[l] as root every time?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always taking the left end makes a linked-list spine, not height-balanced', 'next' => 'ret'],
                ['label' => 'Any root is fine; the judge only checks BST, not height', 'next' => 'wrong_height'],
            ],
        ],
        'wrong_height' => [
            'message' => "You are wrong. The problem requires a height-balanced BST. A chain from always using nums[l] fails that.\nStep back to when you ignored height.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Either floor or ceil mid can work; the sample accepts more than one tree.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The constructed root, not a count and not nested level lists', 'next' => 'success'],
                ['label' => 'The integer Unique BST I Catalan count f[n]', 'next' => 'wrong_count'],
            ],
        ],
        'wrong_count' => [
            'message' => "You are wrong. Unique BST I returns how many trees. This returns one tree.\nStep back to when you returned a count.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Mid of [l, r] is the root; recurse on the two halves. O(n). Not Unique BST I/II, not Level Order, not Construct from traversals, not always-left chain.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
