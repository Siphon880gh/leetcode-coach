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
            'message' => "Problem: n×n matrix (n up to 300), each row and each column non-decreasing. Return the kth smallest in sorted order, not the kth distinct. [[1,5,9],[10,11,13],[12,13,15]], k = 8 → 13 (sorted: 1,5,9,10,11,12,13,13,15). [[-5]], k = 1 → -5. Memory should beat flattening the whole matrix.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Flatten then sort, or treat this as Kth Largest (215) on an unsorted 1D array', 'next' => 'wrong_flat'],
                ['label' => 'Binary search the value between the corner cells; count how many entries are ≤ mid', 'next' => 'count'],
            ],
        ],
        'wrong_flat' => [
            'message' => "You are wrong here. Flatten-and-sort uses O(n²) extra memory. 215 is one unsorted array; here rows and columns are already sorted.\nStep back to when you flattened or used 215.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'count' => [
            'message' => "The answer sits between matrix[0][0] and matrix[n−1][n−1]. For a candidate mid, start at the bottom-left (n−1, 0). If matrix[i][j] ≤ mid, the prefix of that column above i is also ≤ mid (add i+1) and step j right; else step i up. The walk is O(n). If the count is at least k, search [left, mid]; else [mid+1, right].\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Search row-major indices as if the matrix were one flattened sorted array', 'next' => 'wrong_idx'],
                ['label' => 'Count from the bottom-left; left at the end is a matrix value (lower bound)', 'next' => 'kind'],
            ],
        ],
        'wrong_idx' => [
            'message' => "You are wrong. 12 sits before 13 in the last row while 13 already appeared above. Row-major order is not globally sorted.\nStep back to when you searched indices instead of values.",
            'outcome' => 'wrong',
            'rewind_to' => 'count',
            'choices' => [],
        ],
        'kind' => [
            'message' => "A min-heap of row heads also works (same idea as Find K Pairs) but uses O(n) extra. Do not skip the second 13 — this is not distinct. Do not count only one cell per column.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Value binary search plus O(n) count. Example → 13. Not flatten. Not 215', 'next' => 'success'],
                ['label' => 'Skip duplicate 13s, or return 12 because it is the 8th cell in row-major order', 'next' => 'wrong_dup'],
            ],
        ],
        'wrong_dup' => [
            'message' => "You are wrong. Both 13s count. The 8th in sorted order is 13, not the 8th in row-major order.\nStep back to when you skipped a duplicate or used row-major rank.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Binary search the value; count ≤ mid from the bottom-left. [[1,5,9],[10,11,13],[12,13,15]], k = 8 → 13. Not flatten. Not 215.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
