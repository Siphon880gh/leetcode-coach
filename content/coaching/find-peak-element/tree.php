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
            'message' => "Problem: return any peak index. A peak is strictly greater than its neighbors; imagine nums[-1] and nums[n] are -∞. Neighbors never equal. Must be O(log n). [1,2,3,1] → 2.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Linear scan for a local max, Find Min Rotated vs last, or One Edit suffixes', 'next' => 'lin'],
                ['label' => 'Binary search: if nums[mid] > nums[mid+1], peak is on the left including mid', 'next' => 'bs'],
            ],
        ],
        'lin' => [
            'message' => "A scan is O(n). Find Min Rotated compares mid to the last value and returns a min, not a peak index. One Edit is strings.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Search for a given target like Search Rotated I', 'next' => 'wrong_tgt'],
                ['label' => 'The slope nums[mid] vs nums[mid+1] tells which half still has a peak', 'next' => 'bs'],
            ],
        ],
        'wrong_tgt' => [
            'message' => "You are wrong here.\nThere is no target. Any peak is fine. Compare neighbors, not a search key.\nStep back to when you treated this as target search.",
            'outcome' => 'wrong',
            'rewind_to' => 'lin',
            'choices' => [],
        ],
        'bs' => [
            'message' => "left = 0, right = n-1. While left < right: mid = (left+right) >> 1. If nums[mid] > nums[mid+1], right = mid (mid can be the peak). Else left = mid+1. Return left.\nOn [1,2,3,1], mid is 1, nums[1]=2 vs nums[2]=3. What next?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '2 < 3 so left = mid+1 = 2; next mid is 2, 3 > 1 so right = 2; return index 2', 'next' => 'ans'],
                ['label' => 'Return the value 3, or set right = mid because 2 looks smaller than 3’s other side', 'next' => 'wrong_val'],
            ],
        ],
        'wrong_val' => [
            'message' => "You are wrong. The answer is an index. And when mid is climbing (2 < 3) you must move left up, not shrink right onto mid.\nStep back to when you scored [1,2,3,1].",
            'outcome' => 'wrong',
            'rewind_to' => 'bs',
            'choices' => [],
        ],
        'ans' => [
            'message' => "[1,2,1,3,5,6,4] may return 1 (value 2) or 5 (value 6). O(log n). Not Find Min Rotated, not a linear max.\nWhat is [1,2,3,1]?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '2 — the index of 3', 'next' => 'success'],
                ['label' => '3 the peak value, or 1 as if Find Min Rotated', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. Return index 2, not the value 3, and not the rotated-array minimum.\nStep back to when you named the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Binary search on the slope: greater than the right neighbor → keep mid; else climb right. Return an index. Not linear scan, not Find Min vs last, not One Edit. [1,2,3,1] → 2.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
