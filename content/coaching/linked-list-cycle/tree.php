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
            'message' => "Problem: return true if the list has a cycle. pos is not an input. [3,2,0,-4] with a cycle into index 1 → true. [1] acyclic → false. Follow-up: O(1) extra memory.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Linked List Cycle II’s entrance node, a set of values, Copy List’s random map, or treat pos as a parameter', 'next' => 'other'],
                ['label' => 'Floyd: slow and fast start at head; slow steps 1, fast steps 2; they meet iff there is a cycle', 'next' => 'floyd'],
            ],
        ],
        'other' => [
            'message' => "This problem is a boolean, not the start of the loop. Duplicate values are allowed without a cycle. pos is hidden. A node-identity set works but uses O(n) extra, missing the follow-up.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count nodes; if you visit more than n you have a cycle — but n is not given as a number', 'next' => 'wrong_other'],
                ['label' => 'Two pointers, O(1) extra: if fast hits null there is no loop; if fast catches slow there is', 'next' => 'floyd'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nYou are not given n as an integer, and you must not walk forever hoping to count. Floyd never needs the length.\nStep back to when you counted n.",
            'outcome' => 'wrong',
            'rewind_to' => 'other',
            'choices' => [],
        ],
        'floyd' => [
            'message' => "slow = fast = head. while fast and fast.next: slow = slow.next; fast = fast.next.next; if slow is fast: return True. Else False.\nWhy check fast.next before taking two steps?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'fast.next.next would crash (or skip) on the last node of an acyclic list', 'next' => 'ret'],
                ['label' => 'You should start fast one step ahead, or they meet immediately at head and always return true', 'next' => 'wrong_start'],
            ],
        ],
        'wrong_start' => [
            'message' => "You are wrong. They start equal, then you move before comparing, so a one-node acyclic list returns false. Starting fast ahead is optional, not required.\nStep back to when you compared before the first step.",
            'outcome' => 'wrong',
            'rewind_to' => 'floyd',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Time O(n), extra O(1). A hash set of nodes is O(n) extra and also correct. Return a boolean, not the meeting node.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'true on a meet, false when fast runs off the end', 'next' => 'success'],
                ['label' => 'The node where they meet (Cycle II)', 'next' => 'wrong_node'],
            ],
        ],
        'wrong_node' => [
            'message' => "You are wrong. Cycle II asks for the entrance. Here you only report whether a cycle exists.\nStep back to when you returned a node.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Floyd slow/fast, compare after moving, O(1) extra. true/false only. Not Cycle II’s entrance, not a value set, not Copy List, not using pos.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
