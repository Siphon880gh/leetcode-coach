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
            'message' => "Problem: singly linked list. You receive only the node to delete — not head. Values unique. node is in the list and not the tail. After the call that value is gone, length drops by one. [4,5,1,9] delete 5 → [4,1,9]. Void function.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Remove Linked List Elements (203): walk from a dummy head and skip matches, or set prev.next', 'next' => 'head'],
                ['label' => 'Copy node.next.val into node.val, then node.next = node.next.next', 'next' => 'copy'],
            ],
        ],
        'head' => [
            'message' => "You have no head and no prev pointer. You cannot prev.next = node.next. 203 needs the list start.\nHow do you unlink without prev?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Overwrite this node with its successor, then skip the successor object', 'next' => 'copy'],
                ['label' => 'Return node.next as a new head so the caller drops this object', 'next' => 'wrong_return'],
            ],
        ],
        'wrong_return' => [
            'message' => "You are wrong here.\nThe function is void. Callers still hold the given object; you must mutate it in place.\nStep back to when you returned a new head.",
            'outcome' => 'wrong',
            'rewind_to' => 'head',
            'choices' => [],
        ],
        'copy' => [
            'message' => "The given object stays in the chain; it now holds the old next value. The next object is unlinked. Do not try this on a tail (no next to copy). Samples: delete 5 → [4,1,9]; delete 1 → [4,5,9].\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[4,5,1,9] delete 5 → [4,1,9]; delete 1 → [4,5,9]', 'next' => 'cpx'],
                ['label' => 'node.next = node.next.next without copying val — the 5 stays, the 1 is dropped', 'next' => 'wrong_skip'],
            ],
        ],
        'wrong_skip' => [
            'message' => "You are wrong. Skipping next without copying leaves the old val (5) in the list and deletes the wrong node.\nStep back to when you skipped the copy.",
            'outcome' => 'wrong',
            'rewind_to' => 'copy',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(1) time and space. Not 203, not a prev pointer, not a returned head, not skip-without-copy.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy next val, skip next; not 203, not prev, not return, not skip-only', 'next' => 'success'],
                ['label' => 'Reverse Linked List (206) then drop the last node of the reversed chain', 'next' => 'wrong_206'],
            ],
        ],
        'wrong_206' => [
            'message' => "You are wrong. Reversing the whole list is unrelated and you still lack the head. This is a one-node overwrite.\nStep back to when you used 206.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. node.val = node.next.val; node.next = node.next.next. Void, O(1). Not 203, not a prev pointer, not a returned head, not skip-without-copy.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
