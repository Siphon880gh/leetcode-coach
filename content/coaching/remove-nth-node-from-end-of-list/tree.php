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
            'message' => "Problem: remove the n-th node from the end. [1,2,3,4,5], n = 2 → [1,2,3,5]. [1], n = 1 → []. Follow-up: one pass.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Walk the list to count sz, then walk again to index sz − n and splice', 'next' => 'two_pass'],
                ['label' => 'Dummy head; fast leads by n; then fast and slow walk together', 'next' => 'gap'],
            ],
        ],
        'two_pass' => [
            'message' => "Two passes work, but you can keep a gap of n so the second walk is free. Also, deleting the real head needs a node before head.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Start fast and slow on head with no dummy — if n equals the length, slow already sits on the victim', 'next' => 'wrong_nodummy'],
                ['label' => 'dummy → head; fast = slow = dummy; advance fast n times; then while fast.next, move both; slow.next = slow.next.next', 'next' => 'gap'],
            ],
        ],
        'wrong_nodummy' => [
            'message' => "You are wrong here.\nWithout a dummy, there is no predecessor when the nth-from-end is the head. You would unlink the wrong node or return a dangling next.\nStep back to when you chose the start nodes.",
            'outcome' => 'wrong',
            'rewind_to' => 'two_pass',
            'choices' => [],
        ],
        'gap' => [
            'message' => "After fast has moved n steps from dummy, the gap is n edges. Walking until fast.next is null parks slow on the predecessor of the nth-from-end.\nWhy stop on fast.next, not on fast == null?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'fast already sits n ahead; you need slow one behind the victim, so stop when fast has no next', 'next' => 'example'],
                ['label' => 'Keep going until fast is null so slow lands on the victim itself, then victim.next = victim.next.next', 'next' => 'wrong_onnode'],
            ],
        ],
        'wrong_onnode' => [
            'message' => "You are wrong. Splicing requires the predecessor. If slow is the victim, you cannot relink the previous node.\nStep back to when you chose the stop condition.",
            'outcome' => 'wrong',
            'rewind_to' => 'gap',
            'choices' => [],
        ],
        'example' => [
            'message' => "[1,2,3,4,5], n = 2: dummy-1-2-3-4-5. Fast jumps 2 to 2. Joint walk until fast is 5; slow is 3; drop 4. Return dummy.next.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(sz) time, O(1) extra space — one pass after the dummy', 'next' => 'success'],
                ['label' => 'O(sz) extra space because you must store the predecessor of every node', 'next' => 'wrong_stack'],
            ],
        ],
        'wrong_stack' => [
            'message' => "You are wrong. Two pointers and a dummy are enough. No stack of predecessors.\nStep back to when you scored the scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Dummy before head. Fast leads by n. Move both until fast.next is null. Unlink slow.next. Return dummy.next. Time O(sz), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
