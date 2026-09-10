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
            'message' => "Problem: two arrays sorted non-decreasing, lengths up to 1e5, k up to 1e4. Return k pairs (one from each array) with the smallest sums. [1,7,11] and [2,4,6], k=3 → [[1,2],[1,4],[1,6]]. Duplicate values are distinct pairs: [1,1,2] and [1,2,3], k=2 → two copies of [1,1]. k is at most the product of the lengths.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Build every pair, sort by sum, take the first k', 'next' => 'wrong_all'],
                ['label' => 'Min-heap on a virtual matrix: seed (i, 0) for the first k rows of nums1', 'next' => 'heap'],
            ],
        ],
        'wrong_all' => [
            'message' => "You are wrong here. Lengths can be 1e5, so the product of the lengths will not fit in time or memory.\nStep back to when you materialised every pair.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'heap' => [
            'message' => "M[i][j] = nums1[i] + nums2[j]. Each row and each column is sorted. Seed at most k rows: push (nums1[i] + nums2[0], i, 0). Then k times: pop the smallest, emit [nums1[i], nums2[j]], and if j+1 is in range push the next column on that row. You never enqueue (i, j) unless (i, j−1) already left (or j is 0), so no visited set.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Seed every row of nums1 even when k is tiny, or skip pushing j+1 after a pop', 'next' => 'wrong_seed'],
                ['label' => 'Cap the seed at min(k, len(nums1)); always offer the next unused column after a pop', 'next' => 'kind'],
            ],
        ],
        'wrong_seed' => [
            'message' => "You are wrong. Seeding 1e5 rows when k is 3 wastes work. Skipping j+1 truncates a cheap row (the 1-row in the first example).\nStep back to when you over-seeded or dropped the next column.",
            'outcome' => 'wrong',
            'rewind_to' => 'heap',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Merge k Sorted Lists (23) splices list nodes. Kth Smallest in a Sorted Matrix (378) is this heap idea on a real matrix. 215 ranks one array, not pairs.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Frontier heap along sorted rows, O(k log k). Not all-pairs. Not 23', 'next' => 'success'],
                ['label' => 'Heap only on nums1 like 215, or merge the arrays as linked lists like 23', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. 215 never pairs two arrays. 23 walks list pointers, not a virtual sum matrix.\nStep back to when you treated this as 215 or 23.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Seed (i, 0) for the first k rows, pop the smallest sum, push (i, j+1). [1,7,11] and [2,4,6], k=3 → the three 1-pairs. Not all pairs. Not 23.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
