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
            'message' => "Problem: bitwise AND of every integer in [left, right], inclusive. 5..7 → 4. 0..0 → 0. 1..2147483647 → 0. 0 ≤ left ≤ right ≤ 2³¹ − 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Loop i from left to right ANDing every integer, or Hamming-weight the endpoints', 'next' => 'loop'],
                ['label' => 'While left < right, right becomes right AND (right minus 1); then return right', 'next' => 'strip'],
            ],
        ],
        'loop' => [
            'message' => "The span can be two billion; walking it times out. Number of 1 Bits counts set bits, not the range AND.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Number of Islands: flood-fill a grid of 1s', 'next' => 'wrong_grid'],
                ['label' => 'Clear the lowest 1 of right until it no longer exceeds left — common bit prefix', 'next' => 'strip'],
            ],
        ],
        'wrong_grid' => [
            'message' => "You are wrong here.\nNumber of Islands is a grid flood. This is two integers and a range AND.\nStep back to when you reused Number of Islands.",
            'outcome' => 'wrong',
            'rewind_to' => 'loop',
            'choices' => [],
        ],
        'strip' => [
            'message' => "7 (111) → 6 (110) → 4 (100). 4 is no longer greater than 5, so the AND is 4. Shifting both sides right until equal, then shifting back, is the same prefix.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '5..7 is 4; 1..2147483647 is 0', 'next' => 'cpx'],
                ['label' => '5..7 is 7 (OR) or 5 (left endpoint only)', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. AND of 5, 6, and 7 is 4, not OR and not the left endpoint alone.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'strip',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "At most 32 clears. Time O(1). Space O(1).\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Common prefix via Kernighan on right; not a full scan, not Hamming weight', 'next' => 'success'],
                ['label' => 'Must AND every integer; 32 clears cannot cover a two-billion span', 'next' => 'wrong_scan'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong. Once a bit flips inside the range it cannot survive the AND. Clearing right’s lowest 1s finds the shared prefix without visiting the span.\nStep back to when you required a full scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. While left < right, right AND (right minus 1). Return right. O(1). Not a two-billion loop, not Hamming weight, not Number of Islands.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
