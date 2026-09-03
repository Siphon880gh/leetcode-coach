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
            'message' => "Problem: same next pointers as 116, but the tree is not perfect. [1,2,3,4,5,null,7] → [1,#,2,3,#,4,5,7,#] so 5.next is 7. Empty → []. Up to 6000 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '116’s perfect-tree wiring: left.next = right; right.next = parent.next.left', 'next' => 'perf'],
                ['label' => 'Same BFS as 116: snapshot the row, link prev.next, enqueue only existing children', 'next' => 'bfs'],
            ],
        ],
        'perf' => [
            'message' => "parent.next.left is often missing. Here 2.right=5 and 3.left is None, so 5 must skip to 7, not to a null left.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Flatten 114’s preorder spine, or Distinct Subsequences counts', 'next' => 'wrong_flat'],
                ['label' => 'Level-order queue: missing children are never enqueued, so 5 and 7 sit adjacent in that row', 'next' => 'bfs'],
            ],
        ],
        'wrong_flat' => [
            'message' => "You are wrong here.\nFlatten rewires .right in preorder. Distinct Subsequences is string DP. This still fills .next left to right per level.\nStep back to when you reused those problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'perf',
            'choices' => [],
        ],
        'bfs' => [
            'message' => "Identical loop to 116: p=None each level; if p: p.next=node; enqueue left then right if they exist. Time O(n).\nWhy does the same code work without “every parent has two children”?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The queue only holds real nodes of this level, so gaps are skipped automatically', 'next' => 'ret'],
                ['label' => 'You must insert dummy nodes for null children so the row stays a complete binary tree', 'next' => 'wrong_dummy'],
            ],
        ],
        'wrong_dummy' => [
            'message' => "You are wrong. Dummy placeholders would invent next targets that are not in the tree. Only real children are enqueued.\nStep back to when you padded nulls.",
            'outcome' => 'wrong',
            'rewind_to' => 'bfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return root. Last node of a row still has next=None (#).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The same root, not Level Order’s nested value lists', 'next' => 'success'],
                ['label' => 'A boolean like Path Sum', 'next' => 'wrong_bool'],
            ],
        ],
        'wrong_bool' => [
            'message' => "You are wrong. The judge inspects next pointers on the mutated tree.\nStep back to when you returned true/false.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. BFS per level still works when the tree is not perfect; enqueue only existing kids so 5.next=7. O(n). Not 116’s left.next=right shortcut, not Flatten, not Level Order lists, not Distinct Subsequences.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
