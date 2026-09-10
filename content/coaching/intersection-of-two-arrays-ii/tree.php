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
            'message' => "Problem: intersection with multiplicity. A value x appears as many times as it shows in both arrays (the smaller count). Any order. [1,2,2,1] and [2,2] → [2,2]. Lengths up to 1000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Unique only like Intersection of Two Arrays (349), so example 1 is [2]', 'next' => 'wrong_349'],
                ['label' => 'Count nums1; walk nums2 and emit while the leftover count is still positive', 'next' => 'cnt'],
            ],
        ],
        'wrong_349' => [
            'message' => "You are wrong here. 349 is a set. This problem keeps duplicates: two 2s in both arrays means [2,2].\nStep back to when you unique-ified.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'cnt' => [
            'message' => "cnt[x] = how often x appears in nums1 (hash, or a 1001-slot table). Scan nums2: if cnt[x] > 0, append x and decrement. That spends at most the leftover budget.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep emitting as long as x appears in nums2, even after cnt hits 0', 'next' => 'wrong_over'],
                ['label' => 'If both are already sorted, two pointers emit on equals and advance the smaller side', 'next' => 'cpx'],
            ],
        ],
        'wrong_over' => [
            'message' => "You are wrong. You cannot emit more copies than nums1 had. Decrement is the budget.\nStep back to when you ignored the leftover count.",
            'outcome' => 'wrong',
            'rewind_to' => 'cnt',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Follow-up: count the smaller array; if nums2 is on disk, stream it and spend in-memory counts. Time O(n + m). Space O(n) (or O(1) extra with a 1001-slot table).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Shared counts, any order. Not 349. Sorted two-pointers if already sorted', 'next' => 'success'],
                ['label' => 'Require a sorted answer even when the inputs are unsorted', 'next' => 'wrong_ord'],
            ],
        ],
        'wrong_ord' => [
            'message' => "You are wrong. Order is free unless a follow-up already sorted the inputs.\nStep back to when you forced a sort of the output.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Keep the shared count: count one array, spend on the other. [1,2,2,1] ∩ [2,2] is [2,2]. Not unique-only 349.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
