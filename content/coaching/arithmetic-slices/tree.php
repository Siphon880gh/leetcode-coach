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
            'message' => "Problem: nums length 1 to 5000, values -1000 to 1000. Count contiguous subarrays of length at least 3 whose consecutive differences are equal. [1,2,3,4] → 3 ([1,2,3], [2,3,4], [1,2,3,4]). [1] → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count arithmetic subsequences (446), or require the whole array to be arithmetic', 'next' => 'wrong_446'],
                ['label' => 'Walk adjacent pairs. Count every contiguous arithmetic run of length at least 3', 'next' => 'run'],
            ],
        ],
        'wrong_446' => [
            'message' => "You are wrong here. Arithmetic Slices II (446) counts subsequences, not subarrays. A mixed array can still contain many arithmetic slices; you do not need the whole nums to share one difference.\nStep back to when you used 446 or a whole-array check.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'run' => [
            'message' => "Keep previous difference d (sentinel 3000, outside the value range) and a counter of extra triples that end at this pair. If b-a equals d, increment the counter; else set d to the new difference and reset the counter to 0. Then add the counter to the answer.\nHow many does [1,2,3,4] add?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only 1, the full [1,2,3,4], skipping the length-3 slices', 'next' => 'wrong_full'],
                ['label' => '1 when 3 lands, then 2 when 4 lands, total 3', 'next' => 'kind'],
            ],
        ],
        'wrong_full' => [
            'message' => "You are wrong. A run of length L ending at this pair contributes L-2 slices that end here. Do not skip the shorter slices inside the run.\nStep back to when you counted only the full run.",
            'outcome' => 'wrong',
            'rewind_to' => 'run',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Same add-the-run idea as Number of Zero-Filled Subarrays (2348), but here the run is a constant difference, not zeros. One pass, O(1) extra space.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Extend a constant-diff run. Each new index adds that many slices. Not 446', 'next' => 'success'],
                ['label' => 'Restart a nested scan from every i so you recount the same slices', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. The one-pass counter already adds every slice that ends at the current index. Nested rescans are slower and easy to double-count.\nStep back to when you nested a second scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Walk pairs. Same difference grows the ending-slice counter; a break resets it. [1,2,3,4] → 3. Not 446.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
