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
            'message' => "Problem: return the first node shared by headA and headB, or null. Lists have no cycles. Same value is not enough: in [4,1,8,4,5] and [5,6,1,8,4,5] the two 1s are different objects; they meet at the 8.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Floyd cycle, match by val, or hash every node of A then scan B', 'next' => 'floyd'],
                ['label' => 'Two pointers: when a dies, jump to headB; when b dies, jump to headA; stop when a == b', 'next' => 'swap'],
            ],
        ],
        'floyd' => [
            'message' => "There is no cycle. Matching val is wrong (two 1s). A set of A’s nodes is O(m) extra memory; the follow-up wants O(1).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Still compare node.val while walking both lists in lockstep from the heads', 'next' => 'wrong_val'],
                ['label' => 'Walk a through A then B, b through B then A, so both cover m+n and meet at the join or at null', 'next' => 'swap'],
            ],
        ],
        'wrong_val' => [
            'message' => "You are wrong here.\nThe judge checks identity, not value. Lockstep from the heads also fails when skipA and skipB differ.\nStep back to when you compared values.",
            'outcome' => 'wrong',
            'rewind_to' => 'floyd',
            'choices' => [],
        ],
        'swap' => [
            'message' => "while a != b: a = a.next if a else headB; b = b.next if b else headA. Return a. After the switch, leftover prefixes cancel: both have walked the same length.\nIf the lists never join, what do a and b become?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Both null at the same step, so return null', 'next' => 'ans'],
                ['label' => 'They loop forever because null never equals null', 'next' => 'wrong_loop'],
            ],
        ],
        'wrong_loop' => [
            'message' => "You are wrong. In Python and Java, null == null is true, so the while stops and you return null.\nStep back to when you feared an infinite loop.",
            'outcome' => 'wrong',
            'rewind_to' => 'swap',
            'choices' => [],
        ],
        'ans' => [
            'message' => "Example 1 meets at the node whose value is 8. Example 3 ([2,6,4] and [1,5]) has no shared node. Time O(m+n), space O(1). Not Floyd, not LC 159’s window.\nWhat is Example 3?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'null — disjoint lists', 'next' => 'success'],
                ['label' => 'The node 8 from Example 1, or the first 1 by value', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. Disjoint lists return null. Do not reuse Example 1’s 8 or a value match.\nStep back to when you scored the empty intersection.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Switch lists at null so both walk m+n. Meet by identity. Not Floyd, not hashing A, not comparing val. Example 1 → node 8. Example 3 → null.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
