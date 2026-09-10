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
            'message' => "Problem: a singly linked list is a palindrome iff values read the same forward and backward. [1,2,2,1] → true. [1,2] → false. Length 1 to 10⁵. Follow-up: O(n) time, O(1) extra space.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy every val into an array (or Palindrome Number on the whole integer) then two-index check', 'next' => 'copy'],
                ['label' => 'Fast/slow find the mid, reverse the right half, walk head against the reversed half', 'next' => 'mid'],
            ],
        ],
        'copy' => [
            'message' => "An array copy is O(n) extra and fails the follow-up. Palindrome Number (9) reverses digits of one int, not a list. You cannot walk backward — there is no prev pointer.\nHow do you stay O(1) extra?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'slow at head, fast at head.next; while fast can take two steps, slow takes one. Reverse slow.next, then compare', 'next' => 'mid'],
                ['label' => 'Reverse the entire list from head, then walk from the original head', 'next' => 'wrong_whole'],
            ],
        ],
        'wrong_whole' => [
            'message' => "You are wrong here.\nReversing the whole chain from head loses the left half. You need the original left still reachable to compare.\nStep back to when you reversed everything.",
            'outcome' => 'wrong',
            'rewind_to' => 'copy',
            'choices' => [],
        ],
        'mid' => [
            'message' => "slow lands at the last node of the left half. Reverse slow.next with save-nxt-rewire. Then walk pre (new head of the reversed right) against head: if any val differs, false. Odd length leaves the middle unused; the reversed half is shorter, so stop when pre is null.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,2,2,1] true; [1,2] false', 'next' => 'cpx'],
                ['label' => 'Skip reversing: try to walk the right half backward with a prev pointer the list never had', 'next' => 'wrong_prev'],
            ],
        ],
        'wrong_prev' => [
            'message' => "You are wrong. Singly linked nodes have no prev. You reverse the right half so you can walk it forward.\nStep back to when you skipped the reverse.",
            'outcome' => 'wrong',
            'rewind_to' => 'mid',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(1) extra. Not an array copy, not Palindrome Number, not reversing the whole list, not walking backward.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Mid, reverse right, compare; not array copy, not 9, not reverse-all, not a phantom prev', 'next' => 'success'],
                ['label' => 'Reverse Linked List (206) on the whole chain and return whether head still equals the old first val', 'next' => 'wrong_206'],
            ],
        ],
        'wrong_206' => [
            'message' => "You are wrong. 206 flips the entire list. After that, the original head is the old tail; you cannot pair left with right from the lost start.\nStep back to when you reused 206 on the whole list.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Fast/slow to the mid, reverse slow.next, compare pre against head until pre is null. O(n) / O(1). Not an array copy, not Palindrome Number, not reversing everything, not a backward walk.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
