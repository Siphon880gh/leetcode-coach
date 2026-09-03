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
            'message' => "Problem: reorder in place to L0 → Ln → L1 → Ln-1 → … . Do not rewrite node.val. Void return. [1,2,3,4] → [1,4,2,3]. [1,2,3,4,5] → [1,5,2,4,3]. n up to 5e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Swap values, Swap Pairs only, reverse the whole list, Cycle I/II’s meet, or Copy List’s map', 'next' => 'vals'],
                ['label' => 'Mid with slow/fast, cut and reverse the second half, then weave the two chains', 'next' => 'split'],
            ],
        ],
        'vals' => [
            'message' => "The statement forbids changing val. Swap Pairs is 1-2-3-4 → 2-1-4-3, not 1-4-2-3. A full reverse is n…0. Floyd here finds the middle, not a cycle.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Rotate List’s k-gap, or return a new head instead of mutating', 'next' => 'wrong_other'],
                ['label' => 'Second half reversed is Ln, Ln-1, … which you then splice after each front node', 'next' => 'split'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nRotate keeps order, just a new start. This function is void: keep the original head.\nStep back to when you rotated or returned a copy.",
            'outcome' => 'wrong',
            'rewind_to' => 'vals',
            'choices' => [],
        ],
        'split' => [
            'message' => "while fast.next and fast.next.next: slow one, fast two. Then cur = slow.next; slow.next = None. Reverse cur into pre. Weave pre into head.\nWhy stop on fast.next.next, not Cycle I’s fast and fast.next?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'This leaves slow at the last node of the front half so you can cut before reversing', 'next' => 'ret'],
                ['label' => 'It does not matter; any Floyd loop finds the same cut on even and odd n', 'next' => 'wrong_mid'],
            ],
        ],
        'wrong_mid' => [
            'message' => "You are wrong. If slow lands on the first node of the back half, you cut the wrong edge and the weave duplicates or drops a node.\nStep back to when you ignored the cut.",
            'outcome' => 'wrong',
            'rewind_to' => 'split',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Merge: while pre: t=pre.next; pre.next=cur.next; cur.next=pre; cur, pre = pre.next, t. Time O(n), extra O(1). Do not return a value.\nWhat is the result?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'head still starts the list, now 1-4-2-3 or 1-5-2-4-3, void', 'next' => 'success'],
                ['label' => 'Return pre, the reversed second half, as the new head', 'next' => 'wrong_head'],
            ],
        ],
        'wrong_head' => [
            'message' => "You are wrong. The first node stays L0. Returning the reversed half would start at Ln.\nStep back to when you returned pre.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Mid cut, reverse back half, weave. Void, no val writes. Time O(n), extra O(1). Not Swap Pairs, not Rotate List, not Cycle I/II’s boolean/entrance, not Copy List, not a full reverse.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
