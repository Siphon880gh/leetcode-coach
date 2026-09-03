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
            'message' => "Problem: return the node where the cycle starts, or None. Do not modify the list. pos is not an input. [3,2,0,-4] cycle into index 1 → that node. [1] acyclic → None.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Cycle I’s true/false, return the Floyd meeting node, Copy List’s map, or Word Break’s f[n]', 'next' => 'bool'],
                ['label' => 'Floyd until slow==fast, then walk a pointer from head with slow; they meet at the entrance', 'next' => 'floyd'],
            ],
        ],
        'bool' => [
            'message' => "Cycle I only asks existence. The meeting point is usually inside the ring, not the entrance. Hash-of-nodes works but uses extra memory.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Cut next at the meet, or count ring length and jump that many from head', 'next' => 'wrong_other'],
                ['label' => 'After a meet, x = z (mod ring): start one pointer at head, keep slow in the ring, step both by 1', 'next' => 'floyd'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nYou must not modify next. You do not need to measure the ring if you walk from head with the slow pointer.\nStep back to when you rewired the list.",
            'outcome' => 'wrong',
            'rewind_to' => 'bool',
            'choices' => [],
        ],
        'floyd' => [
            'message' => "Same first loop as Cycle I. On meet: ans = head; while ans != slow: both step 1; return ans. If fast hits None, return None.\nWhy reset a pointer to head instead of returning slow?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'slow sits y into the ring; head is x before the ring; those distances meet at the entrance', 'next' => 'ret'],
                ['label' => 'slow is already the entrance because fast lapped it there', 'next' => 'wrong_meet'],
            ],
        ],
        'wrong_meet' => [
            'message' => "You are wrong. They can meet anywhere on the cycle. Sample [3,2,0,-4] need not meet at index 1.\nStep back to when you returned the meeting node.",
            'outcome' => 'wrong',
            'rewind_to' => 'floyd',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Time O(n), extra O(1). Return the entrance node (or None), not a boolean and not pos.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The node where ans and slow meet after the second walk — or None if there was no first meet', 'next' => 'success'],
                ['label' => 'true/false like Cycle I', 'next' => 'wrong_bool'],
            ],
        ],
        'wrong_bool' => [
            'message' => "You are wrong. Cycle I is the boolean. Here the judge wants the ListNode (or None).\nStep back to when you returned a boolean.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Floyd meet, then walk from head with slow. Entrance node or None. O(1) extra. Not Cycle I’s boolean, not the meeting node, not Copy List, not Word Break, do not rewire next.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
