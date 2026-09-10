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
            'message' => "Problem: longest nest of envelopes. A fits in B only if both width and height are strictly larger. No rotation. [[5,4],[6,4],[6,7],[2,3]] → 3 ([2,3] then [5,4] then [6,7]). Three copies of [1,1] → 1. n up to 1e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'For each envelope, scan all others and run O(n squared) LIS-style DP', 'next' => 'wrong_n2'],
                ['label' => 'Sort by width, then longest increasing subsequence on heights (n log n)', 'next' => 'sort'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong here. n is 1e5, so a nested scan of every pair is too slow.\nStep back to when you used quadratic DP.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'sort' => [
            'message' => "Sort width ascending. On equal width, put the taller envelope first. Then patience LIS on the height sequence: append if larger than every tail, else replace the first tail that is at least h.\nWhy reverse height on a width tie?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'So two envelopes with the same width cannot both join an increasing-height chain', 'next' => 'strict'],
                ['label' => 'So equal widths still nest if height increases, like 300 on one axis', 'next' => 'wrong_tie'],
            ],
        ],
        'wrong_tie' => [
            'message' => "You are wrong. Same width cannot nest, even if height grows. The descending-height tie-break blocks that fake chain.\nStep back to when you nested equal widths.",
            'outcome' => 'wrong',
            'rewind_to' => 'sort',
            'choices' => [],
        ],
        'strict' => [
            'message' => "Nesting needs both sides strictly larger. Do not rotate to swap w and h. Do not treat equal height as a fit. The tails array length is the answer, not a reconstruction of the envelopes.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Width up, height down, then LIS on heights. Not quadratic, not rotation, not equal sides', 'next' => 'success'],
                ['label' => 'Rotate any envelope whose height is larger than its width, then sort both axes up', 'next' => 'wrong_rot'],
            ],
        ],
        'wrong_rot' => [
            'message' => "You are wrong. Rotation is forbidden. Sorting both axes ascending also lets same-width pairs sneak into the height LIS.\nStep back to when you rotated or skipped the height reverse.",
            'outcome' => 'wrong',
            'rewind_to' => 'strict',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort width up and height down on ties, then patience LIS on heights. [[5,4],[6,4],[6,7],[2,3]] is 3. Equal width stays out of the chain. Not quadratic DP.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
