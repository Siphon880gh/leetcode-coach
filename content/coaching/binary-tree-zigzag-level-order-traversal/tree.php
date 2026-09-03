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
            'message' => "Problem: zigzag level order — LTR, then RTL, then LTR… [3,9,20,null,null,15,7] → [[3],[20,9],[15,7]]. Empty → []. Up to 2000 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Plain Level Order (always LTR), or Zigzag Conversion bouncing string rows', 'next' => 'plain'],
                ['label' => 'Same BFS snapshot as Level Order; reverse the collected row on odd levels', 'next' => 'bfs'],
            ],
        ],
        'plain' => [
            'message' => "Level Order would emit [9,20] on the second row. Zigzag Conversion fills a string by bouncing a row index — not a tree queue.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Inorder DFS, or Unique Paths counting grid walks', 'next' => 'wrong_inorder'],
                ['label' => 'Enqueue left then right every time; only reverse the value list when left is false', 'next' => 'bfs'],
            ],
        ],
        'wrong_inorder' => [
            'message' => "You are wrong here.\nInorder mixes depths. Unique Paths counts routes. Zigzag still walks the tree by levels.\nStep back to when you left BFS.",
            'outcome' => 'wrong',
            'rewind_to' => 'plain',
            'choices' => [],
        ],
        'bfs' => [
            'message' => "left starts True. After each level, ans.append(t if left else t[::-1]); left ^= 1. Time O(n).\nWhy not enqueue right then left on odd levels instead of reversing t?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The queue must stay left-to-right parent order so the next snapshot is still one contiguous level', 'next' => 'ret'],
                ['label' => 'Drain the whole queue in one pass and reverse the flat list, like a palindrome', 'next' => 'wrong_flat'],
            ],
        ],
        'wrong_flat' => [
            'message' => "You are wrong. A flat reverse is not by levels. The sample is three lists, with only the middle reversed.\nStep back to when you flattened.",
            'outcome' => 'wrong',
            'rewind_to' => 'bfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return ans. Single node [[1]]. Empty [].\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Nested levels with every other row reversed', 'next' => 'success'],
                ['label' => 'Always-LTR nested levels, like Binary Tree Level Order Traversal', 'next' => 'wrong_ltr'],
            ],
        ],
        'wrong_ltr' => [
            'message' => "You are wrong. Level Order never reverses a row. Zigzag’s second row is [20,9], not [9,20].\nStep back to when you skipped the reverse.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. BFS with a level snapshot. Enqueue left then right. Reverse t when left is false, then flip the flag. Empty → []. O(n). Not plain Level Order, not Zigzag Conversion, not inorder.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
