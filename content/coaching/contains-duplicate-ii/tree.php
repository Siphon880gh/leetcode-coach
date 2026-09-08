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
            'message' => "Problem: true if some value sits at two distinct indices i, j with abs(i − j) ≤ k. n and k up to 10⁵. [1,2,3,1] k=3 → true. [1,0,1,1] k=1 → true. [1,2,3,1,2,3] k=2 → false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Seen set like Contains Duplicate, or also bound the value gap like Contains Duplicate III', 'next' => 'any'],
                ['label' => 'Map value → last index; true if i minus last ≤ k, then always write the new i', 'next' => 'map'],
            ],
        ],
        'any' => [
            'message' => "217 is any second copy anywhere: [1,2,3,1,2,3] would be true with no k. 220 also needs |nums[i] − nums[j]| ≤ t. Nested every pair times out at 10⁵.\nWhat is the extra constraint here?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only the index window: same value, |i − j| ≤ k. Last-index map (or a set of the last k+1 values)', 'next' => 'map'],
                ['label' => 'Return the two indices, like Two Sum', 'next' => 'wrong_ret'],
            ],
        ],
        'wrong_ret' => [
            'message' => "You are wrong here.\nThe judge wants true or false, not a pair of indices.\nStep back to when you returned Two Sum data.",
            'outcome' => 'wrong',
            'rewind_to' => 'any',
            'choices' => [],
        ],
        'map' => [
            'message' => "Walk i. If x is in the map and i − last ≤ k, true. Then map[x] = i even when the earlier copy was too far, so the next probe uses the closest previous index. Window set of size k+1 is the same idea.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,2,3,1] k=3 true; [1,0,1,1] k=1 true; [1,2,3,1,2,3] k=2 false (repeats sit 3 apart)', 'next' => 'cpx'],
                ['label' => 'Keep the first index forever; a far early 1 still matches a later 1 even when k is small', 'next' => 'wrong_first'],
            ],
        ],
        'wrong_first' => [
            'message' => "You are wrong. Always overwrite with the latest index. A stale first copy would reject a later pair that is actually within k, or (if you skip the overwrite after a miss) you keep a too-far index.\nStep back to when you froze the first index.",
            'outcome' => 'wrong',
            'rewind_to' => 'map',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(n) extra (or O(min(n, k)) for the sliding set). Boolean only. Copies need not be adjacent unless k is 1.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Last index within k; not 217 anywhere, not 220 value gap, not nested pairs, not Two Sum indices', 'next' => 'success'],
                ['label' => 'The two copies must be neighbors in the original array, so [1,2,3,1] with k=3 is false', 'next' => 'wrong_adj'],
            ],
        ],
        'wrong_adj' => [
            'message' => "You are wrong. Distance up to k, not only 1. [1,2,3,1] with k=3 is true.\nStep back to when you required neighbors.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Same value, indices at most k apart. Last-index map (always update). O(n). Not 217’s anywhere, not 220’s value window, not nested pairs, not Two Sum’s indices, not adjacent-only.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
