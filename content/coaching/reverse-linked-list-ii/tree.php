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
            'message' => "Problem: reverse only the sublist from 1-indexed left to right. [1,2,3,4,5], left=2, right=4 → [1,4,3,2,5]. n ≤ 500.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse the whole list, or reverse every k-window like Reverse Nodes in k-Group', 'next' => 'whole'],
                ['label' => 'Dummy; walk left-1 to the node before the segment; reverse right-left+1 nodes; relink', 'next' => 'seg'],
            ],
        ],
        'whole' => [
            'message' => "A full reverse would put 5 first. k-group reverses disjoint windows of size k, not one closed interval [left, right]. Prefix and suffix stay put.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Rotate List: k mod n then a gap of k', 'next' => 'wrong_rot'],
                ['label' => 'Hold p before left, reverse that run, then p.next = new head and old-head.next = leftover', 'next' => 'seg'],
            ],
        ],
        'wrong_rot' => [
            'message' => "You are wrong here.\nRotate List moves the tail to the front. This inverts a contiguous middle (or prefix) only.\nStep back to when you reused Rotate List.",
            'outcome' => 'wrong',
            'rewind_to' => 'whole',
            'choices' => [],
        ],
        'seg' => [
            'message' => "If left == right or the list has one node, return head. Why a dummy?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'left can be 1, so the original head moves; dummy.next is the new head', 'next' => 'ret'],
                ['label' => 'Dummy is unused; always return the original head like Sorted List keep-one', 'next' => 'wrong_head'],
            ],
        ],
        'wrong_head' => [
            'message' => "You are wrong. When left is 1, the reversed segment starts at the old head, so the new head is dummy.next, not the original head.\nStep back to when you always returned head.",
            'outcome' => 'wrong',
            'rewind_to' => 'seg',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Rewire next pointers; do not copy values. Time O(n), extra O(1). Not Swap Nodes in Pairs (fixed pairs).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'dummy.next — the list with only [left, right] reversed', 'next' => 'success'],
                ['label' => 'The sublist alone, dropping the prefix and suffix', 'next' => 'wrong_drop'],
            ],
        ],
        'wrong_drop' => [
            'message' => "You are wrong. Nodes before left and after right stay attached. The sample keeps 1 and 5.\nStep back to when you returned only the reversed piece.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Dummy; walk to the node before left; reverse right-left+1 nodes; relink both ends. Return dummy.next. O(n). Not a full reverse, not k-group windows, not Rotate List.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
