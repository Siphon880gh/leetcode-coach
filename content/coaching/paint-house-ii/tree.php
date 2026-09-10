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
            'message' => "Problem: n houses, k colors (2 ≤ k ≤ 20), neighbors cannot share a color. costs is n by k. Return min total. [[1,5,3],[2,9,4]] → 5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Paint House (256) three named integers; or greedy cheapest color on every house', 'next' => 'three'],
                ['label' => 'Rolling array of k totals; color j adds the min previous total among colors other than j', 'next' => 'dp'],
            ],
        ],
        'three' => [
            'message' => "256 is this problem with k = 3. k can be 20, so three named variables are not enough. Greedy min of each row can paint two neighbors the same cheap color.\nHow do you update k totals together?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'f starts as row 0. For each later house, g[j] = costs[i][j] plus min(f[h] for h ≠ j). Then f = g', 'next' => 'dp'],
                ['label' => 'Paint Fence: count colorings; ignore the cost matrix', 'next' => 'wrong_fence'],
            ],
        ],
        'wrong_fence' => [
            'message' => "You are wrong here.\nPaint Fence (276) counts ways. This problem returns a min cost with neighbors different.\nStep back to when you counted paintings instead of costs.",
            'outcome' => 'wrong',
            'rewind_to' => 'three',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Naive inner min is O(k) per color, O(n k²) overall — fine here. Follow-up O(n k): remember previous first min, second min, and which color held the min.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[[1,5,3],[2,9,4]] → 5 (0 then 2, or 2 then 0)', 'next' => 'cpx'],
                ['label' => 'Allow two adjacent houses the same color when that color is cheaper', 'next' => 'wrong_same'],
            ],
        ],
        'wrong_same' => [
            'message' => "You are wrong. Adjacent houses must differ even if repeating a color would be cheaper.\nStep back to when you dropped the neighbor constraint.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Answer is min(f) after the last house. Space O(k). Do not enumerate k to the n colorings.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'k rolling costs; next color takes min of the others. First/second min for O(n k)', 'next' => 'success'],
                ['label' => 'House Robber: skip or take each house; some houses stay unpainted', 'next' => 'wrong_rob'],
            ],
        ],
        'wrong_rob' => [
            'message' => "You are wrong. Every house is painted. House Robber forbids adjacent takes; here you forbid adjacent same color.\nStep back to when you skipped houses.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Rolling k totals. Color j cannot reuse the previous total for j. First and second min make it O(n k). Not 256’s three names, not greedy per row, not Paint Fence, not skip/take.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
