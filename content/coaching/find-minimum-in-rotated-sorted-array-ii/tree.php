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
            'message' => "Problem: rotated sorted array, duplicates allowed; return the minimum. [1,3,5] → 1. [2,2,2,0,1] → 0. Follow-up: duplicates change the bound.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Same as Find Min I (unique vs last), Search Rotated II’s boolean, or linear min() only', 'next' => 'one'],
                ['label' => 'Binary search vs nums[r]: greater → go right; equal → r -= 1; less → r = mid', 'next' => 'dup'],
            ],
        ],
        'one' => [
            'message' => "Find Min I compares to a fixed last and assumes unique values, so one half always drops. Search Rotated II asks presence, not the min. Linear min works but is not the binary-search path.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'When nums[mid] == nums[r], set r = mid as if mid were still unique', 'next' => 'wrong_keep'],
                ['label' => 'Equal mid and r give no half to drop, so only decrement r', 'next' => 'dup'],
            ],
        ],
        'wrong_keep' => [
            'message' => "You are wrong here.\nOn [3,3,1,3], mid can equal the last 3 while the min 1 sits to the right of mid. r = mid would search [3,3] and miss 1.\nStep back to when you reused unique-array r = mid on equals.",
            'outcome' => 'wrong',
            'rewind_to' => 'one',
            'choices' => [],
        ],
        'dup' => [
            'message' => "l, r = 0, n-1. While l < r: if nums[mid] > nums[r], l = mid+1; elif equal, r -= 1; else r = mid. Return nums[l]. Compare to the moving right end, not a frozen nums[-1].\nWhy worst case O(n)?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'An all-equal array only shrinks r by 1 each time; extra space still O(1)', 'next' => 'ret'],
                ['label' => 'It stays O(log n) like Find Min I because binary search always halves', 'next' => 'wrong_log'],
            ],
        ],
        'wrong_log' => [
            'message' => "You are wrong. The follow-up is this: equals give no safe half, so you only peel one index. Worst case linear.\nStep back to when you claimed log n always.",
            'outcome' => 'wrong',
            'rewind_to' => 'dup',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Still return the min, not a boolean (that is Search Rotated II). Unique Find Min I needs no r -= 1 branch.\nWhat does [2,2,2,0,1] return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '0 — the valley after the 2s', 'next' => 'success'],
                ['label' => '2, or true like Search Rotated II', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. The min is 0, not the plateau 2, and the return type is the value, not a boolean.\nStep back to when you mixed Find Min II with Search II.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Vs nums[r]: mid > r go right; equal peel r; else keep mid. Return nums[l]. Worst O(n). Not Find Min I’s unique log n, not Search Rotated II’s boolean, not r = mid on equals.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
