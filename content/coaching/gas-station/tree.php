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
            'message' => "Problem: n stations on a circle. From i, you gain gas[i] and spend cost[i] to reach i+1. Start with an empty tank. Return the unique start index that can complete one clockwise loop, or -1. [1,2,3,4,5] vs [3,4,5,1,2] → 3. [2,3,4] vs [3,4,3] → -1. n up to 1e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Simulate a full lap from every i (O(n²)), Jump Game’s farthest index, or start at the station with the most gas', 'next' => 'naive'],
                ['label' => 'One pass: tank += gas[i]-cost[i]; if tank < 0, the next start is i+1 and tank resets to 0', 'next' => 'greedy'],
            ],
        ],
        'naive' => [
            'message' => "n is 1e5, so nested laps TLE. Jump Game is a line and a boolean. Max gas is index 4 here, but 4 cannot finish the loop — 3 can.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Kadane on diffs for the maximum subarray, or return true/false like Jump Game', 'next' => 'wrong_other'],
                ['label' => 'If the tank goes negative at i, every start in the failed stretch is impossible; resume at i+1', 'next' => 'greedy'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nThe judge wants a start index or -1, not a boolean. Max-subarray on diffs is a different problem.\nStep back to when you copied those APIs.",
            'outcome' => 'wrong',
            'rewind_to' => 'naive',
            'choices' => [],
        ],
        'greedy' => [
            'message' => "Also track the total surplus in the same loop (or sum gas vs sum cost). If the grand total is negative, return -1 even if a start index was recorded.\nWhy skip the whole failed stretch instead of retrying i-1?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Any start after the old start and at or before i would arrive at i with even less gas, so it also fails', 'next' => 'ret'],
                ['label' => 'You must walk counterclockwise once, because clockwise is not unique', 'next' => 'wrong_dir'],
            ],
        ],
        'wrong_dir' => [
            'message' => "You are wrong. The problem is clockwise only, and a solution is guaranteed unique if it exists.\nStep back to when you flipped the direction.",
            'outcome' => 'wrong',
            'rewind_to' => 'greedy',
            'choices' => [],
        ],
        'ret' => [
            'message' => "After one O(n) pass: if total surplus < 0 return -1, else return start. Sample 1 starts at 3. Sample 2’s total is negative → -1.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The start index after the last tank reset, or -1 when total gas is less than total cost', 'next' => 'success'],
                ['label' => 'Always 0, because you may begin at any station and the tank is unlimited', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. Unlimited tank capacity still starts empty, and station 0 often cannot even reach station 1.\nStep back to when you always returned 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One pass, reset start to i+1 when tank < 0, then -1 if total surplus is negative. Time O(n), extra O(1). Unique clockwise start. Not Jump Game, not max gas, not Kadane, not O(n²) laps.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
