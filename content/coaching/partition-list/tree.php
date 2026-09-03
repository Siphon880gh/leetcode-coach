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
            'message' => "Problem: partition a linked list so values < x come first, then values ≥ x. Keep each side’s original order. [1,4,3,2,5,2], x = 3 → [1,2,2,4,3,5]. Up to 200 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort the list by value, or Dutch-flag swap like Sort Colors', 'next' => 'sort'],
                ['label' => 'Two dummy lists: left gets val < x, right gets val ≥ x, then join', 'next' => 'two'],
            ],
        ],
        'sort' => [
            'message' => "A full sort would reorder 4,3,5 among themselves. The example keeps 4 before 3 before 5. Sort Colors mutates an array with three pointers; here you rewire nodes and must stay stable.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Drop whole equal runs, like Remove Duplicates from Sorted List II', 'next' => 'wrong_ii'],
                ['label' => 'Append each node onto a less-than chain or a greater-or-equal chain', 'next' => 'two'],
            ],
        ],
        'wrong_ii' => [
            'message' => "You are wrong here.\nList II deletes duplicated values. Partition keeps every node; it only changes which side of x it sits on.\nStep back to when you reused List II.",
            'outcome' => 'wrong',
            'rewind_to' => 'sort',
            'choices' => [],
        ],
        'two' => [
            'message' => "After the walk, set tr.next = None, then tl.next = r.next, return l.next. Why cut the right tail?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The last ≥ x node still points into the old list and would cycle', 'next' => 'ret'],
                ['label' => 'Leave it; dummy.next already isolates the two chains', 'next' => 'wrong_cycle'],
            ],
        ],
        'wrong_cycle' => [
            'message' => "You are wrong. Nodes keep their old next until you overwrite it. The last right node can still point at a left node you already moved, which loops.\nStep back to when you skipped the cut.",
            'outcome' => 'wrong',
            'rewind_to' => 'two',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Equals go on the right (not < x). Empty left is fine: l.next is None until you join r.next. Time O(n), extra O(1).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'l.next — the less-than chain, which now points at the ≥ x chain', 'next' => 'success'],
                ['label' => 'head unchanged, like Sorted List keep-one which never rebuilds', 'next' => 'wrong_head'],
            ],
        ],
        'wrong_head' => [
            'message' => "You are wrong. Sorted List only unlinks extras in place. Here the first node may belong on the right, so the new head is l.next, not the original head.\nStep back to when you returned head.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Dummy left and right; append < x vs ≥ x; tr.next = None; tl.next = r.next; return l.next. Stable. O(n). Not a sort, not Sort Colors, not List II.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
