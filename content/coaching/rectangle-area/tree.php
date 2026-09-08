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
            'message' => "Problem: two axis-aligned rectangles, bottom-left and top-right corners. Return the union area (overlap counted once). Sample A=[−3,0]–[3,4], B=[0,−1]–[9,2] → 45. Identical side-4 squares → 16.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Maximal Rectangle / Maximal Square on a grid, or add A+B and count the overlap twice', 'next' => 'grid'],
                ['label' => 'A plus B minus max(width, 0) times max(height, 0); width = min(rights) − max(lefts)', 'next' => 'union'],
            ],
        ],
        'grid' => [
            'message' => "85 and 221 scan a matrix of cells. Here there are only two boxes. Plain A+B double-counts the intersection when they overlap.\nWhat is the overlap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Width min(ax2,bx2)−max(ax1,bx1), height min(ay2,by2)−max(ay1,by1), clamp each at 0, subtract the product', 'next' => 'union'],
                ['label' => 'Return only the overlap, not the union', 'next' => 'wrong_ov'],
            ],
        ],
        'wrong_ov' => [
            'message' => "You are wrong here.\nThe judge wants the covered union, not the intersection alone.\nStep back to when you returned only the overlap.",
            'outcome' => 'wrong',
            'rewind_to' => 'grid',
            'choices' => [],
        ],
        'union' => [
            'message' => "Area A is (ax2−ax1) times (ay2−ay1). Same for B. A negative width or height means they miss on that axis — overlap 0, union is A+B. Sides are axis-aligned; no rotation.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'First sample 45; two identical [−2,−2]–[2,2] squares → 16 (not 32)', 'next' => 'cpx'],
                ['label' => 'Identical squares of side 4 cover 32 because you add both areas', 'next' => 'wrong_add'],
            ],
        ],
        'wrong_add' => [
            'message' => "You are wrong. Full overlap: subtract the whole square once, so 16 not 32.\nStep back to when you added without subtracting.",
            'outcome' => 'wrong',
            'rewind_to' => 'union',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(1) time and space. Clamp negative overlap. Union, not intersection, not a histogram DP.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A+B minus clamped overlap; not 85/221 grids, not overlap-only, not double-count', 'next' => 'success'],
                ['label' => 'They always overlap, so skip the max(..., 0) clamp', 'next' => 'wrong_clamp'],
            ],
        ],
        'wrong_clamp' => [
            'message' => "You are wrong. Disjoint boxes have a negative projected width or height. Clamp to 0 or you subtract a bogus (negative times negative) positive.\nStep back to when you skipped the clamp.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Union = A + B − max(w,0) times max(h,0). O(1). Not grid DPs, not overlap-only, not A+B when they sit on top of each other, not skipping the clamp.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
