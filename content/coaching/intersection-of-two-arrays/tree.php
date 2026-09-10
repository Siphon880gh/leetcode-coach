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
            'message' => "Problem: unique values that appear in both nums1 and nums2, any order. [1,2,2,1] and [2,2] → [2]. [4,9,5] and [9,4,9,8,4] → [9,4] or [4,9]. Lengths up to 1000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep multiplicity like Intersection of Two Arrays II (350), so example 1 is [2,2]', 'next' => 'wrong_350'],
                ['label' => 'Set of nums1; walk nums2 and emit each hit once, then drop it from the set', 'next' => 'set'],
            ],
        ],
        'wrong_350' => [
            'message' => "You are wrong here. 350 uses min of the two counts. This problem wants each value at most once.\nStep back to when you kept duplicates.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'set' => [
            'message' => "Mark every nums1 value (hash set, or a 1001-slot table). Scan nums2: if x is still marked, append it and unmark so a second copy is not emitted. Time O(n + m).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Require a sorted answer, or leave the mark so [2,2] vs [2,2] emits twice', 'next' => 'wrong_ord'],
                ['label' => 'Any order. Unmark after emit. Sort plus two pointers also works if you skip duplicates', 'next' => 'cpx'],
            ],
        ],
        'wrong_ord' => [
            'message' => "You are wrong. Order is free. If you do not unmark, example 1 becomes [2,2].\nStep back to when you sorted the output or kept the mark.",
            'outcome' => 'wrong',
            'rewind_to' => 'set',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Space O(n) for the set, or O(1) extra with a 1001-slot table (values 0..1000). Nested scan without a set is slower than needed.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Unique intersection. Emit-and-clear. Not 350, not a required order', 'next' => 'success'],
                ['label' => 'A value only in nums1 still counts as a hit', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. Intersection means both arrays. A nums1-only value is not in the answer.\nStep back to when you treated one-sided values as hits.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Unique values in both, any order. Set of one array, emit-and-clear on the other. Not 350, not a required sort.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
