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
            'message' => "Problem: sorted linked list; delete every node whose value appears more than once. [1,2,3,3,4,4,5] → [1,2,5]. [1,1,1,2,3] → [2,3]. Up to 300 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep one of each value, like Remove Duplicates from Sorted List, or keep two like the array II problem', 'next' => 'keep'],
                ['label' => 'Dummy + pre/cur: skip a run of equal vals; if the run is longer than 1, unlink it all', 'next' => 'drop'],
            ],
        ],
        'keep' => [
            'message' => "Problem 83 keeps a single copy. Array II keeps two copies in a vector. Here any duplicated number is removed entirely — both 3s and both 4s are gone.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Dummy plus a gap of n, like Remove Nth Node from End of List', 'next' => 'wrong_nth'],
                ['label' => 'dummy.next = head; walk cur across equals; if pre.next == cur the node is unique, else pre.next = cur.next', 'next' => 'drop'],
            ],
        ],
        'wrong_nth' => [
            'message' => "You are wrong here.\nNth-from-end uses a fixed gap. This problem unlinks whole equal runs; the head itself may be part of a run, so you still want a dummy.\nStep back to when you reused the n-gap.",
            'outcome' => 'wrong',
            'rewind_to' => 'keep',
            'choices' => [],
        ],
        'drop' => [
            'message' => "Inner loop: while cur.next and cur.next.val == cur.val, cur = cur.next. Then if pre.next == cur, pre = cur; else pre.next = cur.next. Why a dummy?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The first nodes may all be duplicates ([1,1,1,2,3] → [2,3]); dummy.next is the new head', 'next' => 'ret'],
                ['label' => 'Skip dummy; mutate head in place like Sort Colors on an array', 'next' => 'wrong_head'],
            ],
        ],
        'wrong_head' => [
            'message' => "You are wrong. If the prefix is a duplicate run, there is no previous node to relink unless you own a dummy. Sort Colors is a different in-place array problem.\nStep back to when you dropped the dummy.",
            'outcome' => 'wrong',
            'rewind_to' => 'drop',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Then cur = cur.next. Time O(n), extra O(1).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'dummy.next — the list of values that appeared exactly once, still sorted', 'next' => 'success'],
                ['label' => 'k, the new length, like Remove Duplicates from Sorted Array II', 'next' => 'wrong_k'],
            ],
        ],
        'wrong_k' => [
            'message' => "You are wrong. This signature returns a ListNode. Array II returns an integer k into a buffer.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Dummy, pre, cur. Collapse equal runs; unlink the whole run when it is not a singleton. Delete every duplicated value — not keep-one (83), not keep-two (array II), not nth-from-end. Time O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
