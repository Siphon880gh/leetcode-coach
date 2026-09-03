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
            'message' => "Problem: sort a singly linked list by insertion sort. [4,2,1,3] → [1,2,3,4]. Up to 5000 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy vals into an array and sort, merge-sort like Sort List, Reorder List’s weave, or LRU’s map', 'next' => 'array'],
                ['label' => 'Dummy pointing at head; walk cur; if out of order, splice cur into the sorted prefix', 'next' => 'splice'],
            ],
        ],
        'array' => [
            'message' => "The problem asks for insertion sort on the list, not n log n merge (that is Sort List) and not an array sort. Reorder List and LRU are different problems.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Swap adjacent pairs like Swap Nodes in Pairs until the list is sorted', 'next' => 'wrong_pairs'],
                ['label' => 'Keep a growing sorted prefix; unlink the next node and insert it by value', 'next' => 'splice'],
            ],
        ],
        'wrong_pairs' => [
            'message' => "You are wrong here.\nSwap Pairs only exchanges neighbors once. Insertion sort may move a node many places left into the already-sorted prefix.\nStep back to when you reused Swap Pairs.",
            'outcome' => 'wrong',
            'rewind_to' => 'array',
            'choices' => [],
        ],
        'splice' => [
            'message' => "dummy = Node(head.val, head); pre, cur = dummy, head. If pre.val <= cur.val, just advance. Else scan p from dummy while p.next.val <= cur.val, then splice: t = cur.next; cur.next = p.next; p.next = cur; pre.next = t; cur = t.\nWhy return dummy.next, not dummy?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'dummy is a sentinel; the real head is whatever sits after it after inserts', 'next' => 'ret'],
                ['label' => 'dummy.val is a real list value, so return dummy as the new head', 'next' => 'wrong_dummy'],
            ],
        ],
        'wrong_dummy' => [
            'message' => "You are wrong. dummy copies the first value only as a sentinel. Returning it duplicates that value. The list starts at dummy.next.\nStep back to when you returned dummy.",
            'outcome' => 'wrong',
            'rewind_to' => 'splice',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Time O(n²), extra O(1). Empty or one node returns head. After splicing, cur is the saved next, not pre.next, because pre still marks the last sorted node.\nWhat happens on [4,2,1,3]?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,2,3,4]; 2 then 1 then 3 each splice left into the growing prefix', 'next' => 'success'],
                ['label' => '[4,2,1,3] unchanged, or [-1,5,3,4,0] stays unsorted', 'next' => 'wrong_stay'],
            ],
        ],
        'wrong_stay' => [
            'message' => "You are wrong. Insertion sort must produce a fully sorted list. The second sample is [-1,0,3,4,5].\nStep back to when you left the list unsorted.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Dummy sentinel; splice out-of-order cur into the sorted prefix; return dummy.next. O(n²). Not array sort, not Sort List merge, not Swap Pairs, not Reorder List, not LRU.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
