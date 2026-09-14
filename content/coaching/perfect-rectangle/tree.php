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
            'message' => "Problem: each rectangle is [x, y, a, b] (bottom-left to top-right), axis-aligned. Return true iff the pieces exact-cover one larger rectangle: no gaps, no overlaps. Up to 2e4 rectangles. The five-piece sample is true; a gap is false; an overlap is false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the union area like 223 / 850, or accept any tiling whose areas add up', 'next' => 'wrong_union'],
                ['label' => 'Require bounding-box area to match the sum, then check corner counts', 'next' => 'area'],
            ],
        ],
        'wrong_union' => [
            'message' => "You are wrong here. 223 and 850 compute union area, which still allows holes outside the pieces or leftover overlap. A gap plus an overlap can cancel so the areas still match.\nStep back to when you used union area or trusted area alone.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'area' => [
            'message' => "Add each rectangle area (width times height). Track minX, minY, maxX, maxY. If the total is not the bounding-box area, there is a gap or overlap. Use a 64-bit sum: one rectangle can overflow 32-bit ints. Then count every corner in a map.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Require every interior corner to appear four times, or skip the 64-bit sum', 'next' => 'wrong_four'],
                ['label' => 'Bounding corners once; remaining points 2 or 4 (T-junctions are 2)', 'next' => 'kind'],
            ],
        ],
        'wrong_four' => [
            'message' => "You are wrong. An edge T-junction is a count of 2, not 4. Fixed 32-bit area overflows on large widths and heights.\nStep back to when you demanded 4 everywhere or used 32-bit area.",
            'outcome' => 'wrong',
            'rewind_to' => 'area',
            'choices' => [],
        ],
        'kind' => [
            'message' => "The four bounding-box corners must appear exactly once. Remove them, then every leftover point must be 2 or 4. A 1 or 3 is a gap or an overlap leftover. Exact cover, not union.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Area plus corners. Five-piece sample true. Not 223', 'next' => 'success'],
                ['label' => 'Return true from area equality alone, or treat a 1-count interior corner as fine', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. Area can match when a gap and an overlap cancel. A lonely interior corner (count 1) means the cover is not perfect.\nStep back to when you skipped corner counts or allowed a 1.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Bounding area must match the sum. Outer corners once; interior 2 or 4. Not 223.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
