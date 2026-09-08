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
            'message' => "Problem: reverse the whole singly linked list. [1,2,3,4,5] → [5,4,3,2,1]. [1,2] → [2,1]. Empty → empty. Up to 5000 nodes. Iterative and recursive both count.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse only [left, right] like Reverse List II, or invert a binary tree’s children', 'next' => 'other'],
                ['label' => 'Head insertion: save nxt, curr.next = dummy.next, dummy.next = curr, curr = nxt', 'next' => 'rev'],
            ],
        ],
        'other' => [
            'message' => "Reverse List II flips a closed interval. Invert Binary Tree swaps left/right on nodes. Here every list next pointer flips.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Isomorphic Strings: two character maps', 'next' => 'wrong_iso'],
                ['label' => 'Rewire next: dummy head-insert, or prev/curr walking; return the new head', 'next' => 'rev'],
            ],
        ],
        'wrong_iso' => [
            'message' => "You are wrong here.\nIsomorphic Strings pairs characters. This rewires a list.\nStep back to when you reused string maps.",
            'outcome' => 'wrong',
            'rewind_to' => 'other',
            'choices' => [],
        ],
        'rev' => [
            'message' => "Save nxt before overwriting curr.next or you lose the rest. Twin: prev=None, same save-rewire-advance, return prev. Recursion: reverse the suffix, then head.next.next = head; head.next = None.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,2,3,4,5] becomes [5,4,3,2,1]; empty stays empty', 'next' => 'cpx'],
                ['label' => 'Only swap the first two, or leave the original head still pointing at 2 (a cycle)', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. The whole chain reverses. The old head must become the tail with next None, or you loop.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'rev',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n). Space O(1) iterative, O(n) recursive stack. Return dummy.next (or prev), not dummy.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Save nxt, head-insert or prev-walk the whole list; not Reverse List II, not Invert Tree', 'next' => 'success'],
                ['label' => 'Copy values into a new array and build a fresh list; rewiring next is illegal', 'next' => 'wrong_copy'],
            ],
        ],
        'wrong_copy' => [
            'message' => "You are wrong. The usual write-up rewires next in O(1) extra. Copying values works but misses the pointer lesson.\nStep back to when you required a new list of nodes.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Save nxt, hang curr on the reversed prefix, advance. Return the new head. O(n) / O(1). Not Reverse List II, not Invert Binary Tree, not a character map.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
