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
            'message' => "Problem: sorted linked list; each value once. [1,1,2] → [1,2]. [1,1,2,3,3] → [1,2,3]. Up to 300 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Unlink every duplicated value entirely, like Remove Duplicates from Sorted List II', 'next' => 'ii'],
                ['label' => 'Walk cur: if cur.val == cur.next.val, skip the next node; else cur = cur.next', 'next' => 'keep'],
            ],
        ],
        'ii' => [
            'message' => "List II drops both 3s. Here you keep a single 1, a single 2, a single 3. Adjacent equals are collapsed, not erased as a group.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Write pointer k into an array, like Remove Duplicates from Sorted Array', 'next' => 'wrong_arr'],
                ['label' => 'On a match, cur.next = cur.next.next and stay; on a mismatch, advance cur', 'next' => 'keep'],
            ],
        ],
        'wrong_arr' => [
            'message' => "You are wrong here.\nThis is a linked list. You rewire next pointers; you do not compact a buffer and return k.\nStep back to when you reused the array write pointer.",
            'outcome' => 'wrong',
            'rewind_to' => 'ii',
            'choices' => [],
        ],
        'keep' => [
            'message' => "Loop while cur and cur.next. After skipping a duplicate, why not always move cur forward?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Three 1s in a row: stay so the next equal is still adjacent to cur', 'next' => 'head'],
                ['label' => 'Always cur = cur.next, even after a skip, like a one-step scan', 'next' => 'wrong_step'],
            ],
        ],
        'wrong_step' => [
            'message' => "You are wrong. If you advance after unlinking, you can leave two equal values adjacent ([1,1,1] would keep two 1s).\nStep back to when you always advanced.",
            'outcome' => 'wrong',
            'rewind_to' => 'keep',
            'choices' => [],
        ],
        'head' => [
            'message' => "No dummy is required: the first node of each run stays, including head. Time O(n), extra O(1).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'head — the same list, now with unique adjacent values', 'next' => 'success'],
                ['label' => 'dummy.next, because the head must be deleted like List II', 'next' => 'wrong_dummy'],
            ],
        ],
        'wrong_dummy' => [
            'message' => "You are wrong. List II may delete the head when the first run is all duplicates. Here the first node of a run is kept, so returning head is enough.\nStep back to when you required a dummy.",
            'outcome' => 'wrong',
            'rewind_to' => 'head',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. cur = head. While cur and cur.next: equal → cur.next = cur.next.next; else cur = cur.next. Keep one of each — not List II (drop the whole run), not array compact+k. Time O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
