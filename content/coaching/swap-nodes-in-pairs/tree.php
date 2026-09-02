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
            'message' => "Problem: swap nodes in pairs. [1,2,3,4] → [2,1,4,3]. [1,2,3] → [2,1,3]. You must not rewrite node.val — only change next pointers.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Walk the list and swap val between each pair of nodes', 'next' => 'vals'],
                ['label' => 'Recurse on the rest, then reverse the current two pointers', 'next' => 'rewire'],
            ],
        ],
        'vals' => [
            'message' => "The problem forbids changing values. Even if the judge only checked values, an odd leftover node and dummy-head tests expect real pointer swaps.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse the whole list, then swap pairs again to undo the middle', 'next' => 'wrong_rev'],
                ['label' => 'If head or head.next is null, return head. Else t = swap(head.next.next); p = head.next; p.next = head; head.next = t; return p', 'next' => 'rewire'],
            ],
        ],
        'wrong_rev' => [
            'message' => "You are wrong here.\nReversing the entire list is a different problem. You only swap adjacent pairs; the last odd node stays in place.\nStep back to when you chose the transform.",
            'outcome' => 'wrong',
            'rewind_to' => 'vals',
            'choices' => [],
        ],
        'rewire' => [
            'message' => "After the recursive call, the suffix is already paired. p is the old second node — it becomes the new head of this pair. head (the old first) must point at t, not at p.\nWhy return p, not head?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The caller needs the new pair head — after the swap that is the former second node', 'next' => 'example'],
                ['label' => 'Return head so the original first node stays the list head', 'next' => 'wrong_head'],
            ],
        ],
        'wrong_head' => [
            'message' => "You are wrong. Returning head leaves 1 still first: [1,2,3,4] would not become [2,1,...]. The pair's new front is p.\nStep back to when you chose the return value.",
            'outcome' => 'wrong',
            'rewind_to' => 'rewire',
            'choices' => [],
        ],
        'example' => [
            'message' => "[1,2,3,4]: recurse on [3,4] → 4-3. Then 2.next = 1, 1.next = 4. Result 2-1-4-3. A dummy + while (cur.next and cur.next.next) loop is the iterative twin, O(1) extra space.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time; recursion O(n) stack, dummy iteration O(1) extra', 'next' => 'success'],
                ['label' => 'O(n log n) because each pair is a merge step', 'next' => 'wrong_nlogn'],
            ],
        ],
        'wrong_nlogn' => [
            'message' => "You are wrong. You visit each node a constant number of times. This is not merge sort.\nStep back to when you scored the walk.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Base: fewer than two nodes, return head. Recurse on head.next.next, then p = head.next; p.next = head; head.next = t; return p. Time O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
