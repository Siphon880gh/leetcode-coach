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
            'message' => "Problem: non-decreasing citations. Largest h such that at least h papers have at least h cites. Must be log time. [0,1,3,5,6] → 3. [1,2,100] → 2.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort descending or count buckets like H-Index (274)', 'next' => 'sort'],
                ['label' => 'Binary search h: last h papers work iff citations[n − h] ≥ h', 'next' => 'bs'],
            ],
        ],
        'sort' => [
            'message' => "274 is for an unsorted list. Here the array is already ascending, and the follow-up is logarithmic time. Sorting or a linear scan from n misses that.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Binary-search paper values as if the list were unsorted', 'next' => 'wrong_raw'],
                ['label' => 'Search the candidate h on 0..n; check citations[n − mid] ≥ mid', 'next' => 'bs'],
            ],
        ],
        'wrong_raw' => [
            'message' => "You are wrong here.\nYou are not looking up a target cite. You are looking for the largest feasible h. The probe is n − h, not a random index.\nStep back to when you treated this as unsorted search.",
            'outcome' => 'wrong',
            'rewind_to' => 'sort',
            'choices' => [],
        ],
        'bs' => [
            'message' => "Upper-bound loop: mid = (left + right + 1) >> 1. If citations[n − mid] ≥ mid, raise left to mid; else drop right to mid − 1. Twin: first i with citations[i] ≥ n − i, then n − i.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[0,1,3,5,6], n = 5: h = 3 because citations[2] ≥ 3. [1,2,100] → 2', 'next' => 'cpx'],
                ['label' => 'Return citations[n − 1], the max cite, as h', 'next' => 'wrong_max'],
            ],
        ],
        'wrong_max' => [
            'message' => "You are wrong. Max cite can exceed n. h cannot. 100 with three papers is not h = 100.\nStep back to when you used the last value as h.",
            'outcome' => 'wrong',
            'rewind_to' => 'bs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(log n) time, O(1) extra. Do not scan every h from n down.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Search h; citations[n − h] ≥ h. Already sorted. Not 274’s sort or count', 'next' => 'success'],
                ['label' => 'Lower-bound mid without the +1 bias, and loop until left == right anyway', 'next' => 'wrong_mid'],
            ],
        ],
        'wrong_mid' => [
            'message' => "You are wrong on this path. This is an upper-bound search (largest feasible h). A plain lower mid can stall. Use the +1 bias, or search the first qualifying index i.\nStep back to when you dropped the bias.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Binary search h on 0..n. The last h papers meet the bar iff citations[n − h] ≥ h. Already sorted — not 274’s sort or count.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
