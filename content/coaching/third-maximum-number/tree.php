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
            'message' => "Problem: nums length 1 to 1e4. Return the third distinct maximum. If fewer than three unique values exist, return the maximum. [3,2,1] → 1. [1,2] → 2. [2,2,3,1] → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Rank like Kth Largest (215), so the two 2s in [2,2,3,1] take first and second', 'next' => 'wrong_215'],
                ['label' => 'Keep three distinct slots. Duplicates share one rank', 'next' => 'slots'],
            ],
        ],
        'wrong_215' => [
            'message' => "You are wrong here. 215 counts duplicate values as separate ranks. Here both 2s count as one distinct max, so [2,2,3,1] is 3 then 2 then 1.\nStep back to when you used 215 ranking.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'slots' => [
            'message' => "Keep m1 > m2 > m3, starting below the 32-bit range (not INT_MIN, because -2^31 can appear). Skip a num already in a slot. Bigger than m1: shift m3, m2, then m1. Else bigger than m2: shift m3 then m2. Else bigger than m3: set m3.\nWhat if m3 is still empty?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return a missing-third placeholder, or 2 for [1,2]', 'next' => 'wrong_two'],
                ['label' => 'Return m1, the maximum. [1,2] → 2', 'next' => 'kind'],
            ],
        ],
        'wrong_two' => [
            'message' => "You are wrong. If the third slot never filled, the statement says return the maximum, not the second and not a dummy.\nStep back to when you treated a missing third as a real answer.",
            'outcome' => 'wrong',
            'rewind_to' => 'slots',
            'choices' => [],
        ],
        'kind' => [
            'message' => "A set plus a descending sort also works at this n. The three-slot walk is the one-pass follow-up. First Missing Positive (41) hunts a missing 1..n, not a ranked max.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Three distinct slots, skip duplicates. [2,2,3,1] → 1. Not 215', 'next' => 'success'],
                ['label' => 'Use 32-bit min as the empty sentinel even if -2^31 can appear', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. If -2^31 is a real value, a 32-bit min sentinel cannot tell empty from that number. Use a 64-bit or language -inf below the range.\nStep back to when you picked the sentinel.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Three distinct slots, skip duplicates, return the max when the third never filled. [3,2,1] → 1. [1,2] → 2. Not 215.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
