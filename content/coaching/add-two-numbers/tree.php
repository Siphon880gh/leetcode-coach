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
            'message' => "Problem: l1 = [2, 4, 3], l2 = [5, 6, 4].\nDigits are stored in reverse order (342 + 465). Return the sum as a linked list.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Convert each list to an integer, add, convert back', 'next' => 'wrong_as_int'],
                ['label' => 'Walk both heads and add digit by digit with a carry', 'next' => 'walk_heads'],
            ],
        ],
        'wrong_as_int' => [
            'message' => "You are wrong here.\nEach list can be 100 digits — that overflows a 64-bit integer. The clean path is grade-school addition on the nodes themselves.\nStep back to when you chose how to add.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'walk_heads' => [
            'message' => "Heads are 2 and 5. Why is it correct to start adding there?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse order: the head is the ones place', 'next' => 'first_sum'],
                ['label' => 'Linked lists must be added from the most significant digit', 'next' => 'wrong_msb'],
            ],
        ],
        'wrong_msb' => [
            'message' => "You are wrong — reverse order means the head is the least significant digit, which is exactly where grade-school addition starts.\nStep back to when you decided where to begin.",
            'outcome' => 'wrong',
            'rewind_to' => 'walk_heads',
            'choices' => [],
        ],
        'first_sum' => [
            'message' => "2 + 5 = 7, carry 0. Next nodes: 4 + 6 = 10. What do you store, and what is the new carry?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Store node 0, set carry to 1', 'next' => 'dummy_head'],
                ['label' => 'Store a single node with value 10', 'next' => 'wrong_write_ten'],
            ],
        ],
        'wrong_write_ten' => [
            'message' => "You are wrong. Each node holds one digit 0–9. A sum of 10 means write 0 and carry 1.\nStep back to when you handled a sum ≥ 10.",
            'outcome' => 'wrong',
            'rewind_to' => 'first_sum',
            'choices' => [],
        ],
        'dummy_head' => [
            'message' => "Keep a dummy head and append digits. Treat a missing node as 0 when lengths differ.\nExample: l1 = [9,9,9,9,9,9,9], l2 = [9,9,9,9]. After the shorter list ends, what do you do?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep looping: leftover digits plus carry, and while carry is nonzero', 'next' => 'final_carry'],
                ['label' => 'Stop when the shorter list ends', 'next' => 'wrong_unequal_stop'],
            ],
        ],
        'wrong_unequal_stop' => [
            'message' => "You are wrong. Unequal length is normal — missing digits are 0, and you still have to flush the carry.\nStep back to when the lists were different lengths.",
            'outcome' => 'wrong',
            'rewind_to' => 'dummy_head',
            'choices' => [],
        ],
        'final_carry' => [
            'message' => "l1 = [9], l2 = [9]. You write 8 and carry is 1. Both lists are exhausted. What next?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Loop because carry is still 1; append a node 1', 'next' => 'success'],
                ['label' => 'Return [8] because both inputs ended', 'next' => 'wrong_drop_carry'],
            ],
        ],
        'wrong_drop_carry' => [
            'message' => "You are wrong. The loop condition is l1 or l2 or carry. A leftover carry becomes another node (9+9 → [8,1]).\nStep back to when both lists ended with a carry still live.",
            'outcome' => 'wrong',
            'rewind_to' => 'final_carry',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Simulate addition on the reversed digits: dummy head, carry, missing nodes as 0. Time O(max(m, n)), extra space O(1) besides the answer.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
