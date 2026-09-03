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
            'message' => "Problem: nums1 has m values then n zeros; nums2 has n values. Merge into nums1 in non-decreasing order. Void. [1,2,3,0,0,0] and [2,5,6] → [1,2,2,3,5,6]. m+n ≤ 200.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Dummy-splice like Merge Two Sorted Lists, or sort nums1 after copying nums2 in', 'next' => 'list'],
                ['label' => 'Two pointers from the ends: write the larger of nums1[i] and nums2[j] at k', 'next' => 'back'],
            ],
        ],
        'list' => [
            'message' => "This is arrays with spare tail in nums1, not list nodes. Copy-then-sort is extra time. The empty slots sit at the right, so you can write from the back without clobbering unread nums1 values.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Merge from index 0: always take the smaller next value into nums1[0..]', 'next' => 'wrong_front'],
                ['label' => 'i = m-1, j = n-1, k = m+n-1; while j ≥ 0, place the larger and step k left', 'next' => 'back'],
            ],
        ],
        'wrong_front' => [
            'message' => "You are wrong here.\nWriting at the front overwrites a nums1 value you still need. The zeros at the end are the safe write zone.\nStep back to when you merged from the front.",
            'outcome' => 'wrong',
            'rewind_to' => 'list',
            'choices' => [],
        ],
        'back' => [
            'message' => "Loop while j ≥ 0. If i ≥ 0 and nums1[i] > nums2[j], copy nums1[i] and i -= 1; else copy nums2[j] and j -= 1. Then k -= 1. Why stop when j is done?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Leftover nums1 values already sit in the right places; leftover nums2 must still be copied', 'next' => 'ret'],
                ['label' => 'Always drain both pointers; leftover nums1 must be copied again', 'next' => 'wrong_drain'],
            ],
        ],
        'wrong_drain' => [
            'message' => "You are wrong. When nums2 is exhausted, the remaining prefix of nums1 is already sorted and already in nums1.\nStep back to when you recopied leftover nums1.",
            'outcome' => 'wrong',
            'rewind_to' => 'back',
            'choices' => [],
        ],
        'ret' => [
            'message' => "m = 0: only nums2 is copied in. n = 0: the loop never runs. Time O(m+n), extra O(1). Not Merge Intervals, not Merge k Sorted Lists.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Nothing — nums1 is mutated in place', 'next' => 'success'],
                ['label' => 'A new merged array, like returning dummy.next on lists', 'next' => 'wrong_new'],
            ],
        ],
        'wrong_new' => [
            'message' => "You are wrong. The signature is void. The merged result lives in nums1.\nStep back to when you returned a new array.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. i = m-1, j = n-1, k = m+n-1. While j ≥ 0, write the larger into nums1[k] and step left. Void, O(m+n). Not Merge Two Sorted Lists, not copy-then-sort, not a front merge.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
