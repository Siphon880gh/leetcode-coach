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
            'message' => "Problem: sort a linked list ascending. [4,2,1,3] → [1,2,3,4]. Up to 5e4 nodes, so O(n²) Insertion Sort List is too slow. Empty list is []. Follow-up: O(n log n) time.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Insertion-sort splices, Sort Colors on vals, Reorder List’s weave, or array sort then rebuild', 'next' => 'insert'],
                ['label' => 'Merge sort: split at mid, recurse both halves, merge like two sorted lists', 'next' => 'merge'],
            ],
        ],
        'insert' => [
            'message' => "Insertion Sort List is O(n²). Sort Colors is an array Dutch flag. Reorder List does not sort. Copying to an array uses extra O(n) and is not the list merge-sort path.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Merge Two Sorted Lists once on the original unsorted head', 'next' => 'wrong_once'],
                ['label' => 'Cut into two halves, sort each, then merge the two sorted halves', 'next' => 'merge'],
            ],
        ],
        'wrong_once' => [
            'message' => "You are wrong here.\nMerge Two Sorted Lists needs two already-sorted lists. One unsorted list is not that input.\nStep back to when you skipped the split.",
            'outcome' => 'wrong',
            'rewind_to' => 'insert',
            'choices' => [],
        ],
        'merge' => [
            'message' => "slow = head, fast = head.next. While fast and fast.next, advance slow by 1 and fast by 2. Then l2 = slow.next; slow.next = None. Recurse on head and l2; merge with a dummy tail taking the smaller val.\nWhy start fast at head.next, not head?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'On two nodes, fast at head would put both in one half and recurse forever', 'next' => 'ret'],
                ['label' => 'Either start works; Floyd Cycle I starts both at head so copy that', 'next' => 'wrong_fast'],
            ],
        ],
        'wrong_fast' => [
            'message' => "You are wrong. Cycle I looks for a meeting, not a midpoint cut. Here fast must start one step ahead so a two-node list splits 1+1.\nStep back to when you copied Floyd’s start.",
            'outcome' => 'wrong',
            'rewind_to' => 'merge',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Must cut slow.next or the halves share a tail and recurse forever. Time O(n log n), stack O(log n). [] and a single node return as-is. Same samples as Insertion Sort List, faster.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'dummy.next after merging the two recursively sorted halves', 'next' => 'success'],
                ['label' => 'head unchanged, or dummy itself', 'next' => 'wrong_head'],
            ],
        ],
        'wrong_head' => [
            'message' => "You are wrong. Recursion returns new heads. dummy is a sentinel; the sorted list starts at dummy.next.\nStep back to when you returned the wrong node.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Split with fast = head.next; cut slow.next; recurse; merge smaller heads. O(n log n). Not Insertion Sort List, not Sort Colors, not Reorder List, not Merge Two Sorted Lists alone, not Floyd’s start.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
