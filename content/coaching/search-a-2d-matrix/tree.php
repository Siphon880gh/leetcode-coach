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
            'message' => "Problem: each row is sorted, and matrix[i][0] > matrix[i-1][n-1]. Find target in O(log(m·n)). [[1,3,5,7],[10,11,16,20],[23,30,34,60]], 3 → true, 13 → false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Scan every cell, or treat it like Search in Rotated Sorted Array', 'next' => 'scan'],
                ['label' => 'Treat the matrix as one sorted array of length m·n; binary-search lower bound; map mid to (mid/n, mid%n)', 'next' => 'flat'],
            ],
        ],
        'scan' => [
            'message' => "A full scan is O(m·n). Rotation is not the invariant: the whole grid is one increasing sequence because each row starts after the previous row ends.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Start at the top-right and walk like Search a 2D Matrix II (rows and cols independently sorted)', 'next' => 'wrong_ii'],
                ['label' => 'Binary search on the flattened index range [0, m·n-1]', 'next' => 'flat'],
            ],
        ],
        'wrong_ii' => [
            'message' => "You are wrong here.\nMatrix II allows a later row to start below an earlier row’s last value. Here the flatten is fully sorted, so one binary search is enough and required for log(m·n).\nStep back to when you used the staircase walk.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'flat' => [
            'message' => "If matrix[x][y] >= target, right = mid, else left = mid+1. After the loop, why check equality instead of returning true immediately?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Lower bound may land on the first value ≥ target; that cell might not equal target (13 → false)', 'next' => 'map'],
                ['label' => 'Any >= means found; 13 should be true because 16 is larger', 'next' => 'wrong_ge'],
            ],
        ],
        'wrong_ge' => [
            'message' => "You are wrong. Example 2 target 13 is false. Lower bound finds 16; you still need == target.\nStep back to when you treated >= as a hit.",
            'outcome' => 'wrong',
            'rewind_to' => 'flat',
            'choices' => [],
        ],
        'map' => [
            'message' => "Index i maps to row i/n, column i%n. Time O(log(m·n)), extra O(1).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'true iff the lower-bound cell equals target — a boolean, not an insertion index', 'next' => 'success'],
                ['label' => 'The flattened index, like Search Insert Position', 'next' => 'wrong_idx'],
            ],
        ],
        'wrong_idx' => [
            'message' => "You are wrong. This signature returns boolean. Search Insert Position returns an array index.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'map',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Flatten to [0, m·n-1]. Lower-bound binary search; map mid with /n and %n. Return whether that cell equals target. Time O(log(m·n)). One sorted stream — not rotated search, and not Matrix II’s staircase.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
