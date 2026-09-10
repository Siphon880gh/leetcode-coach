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
            'message' => "Problem: NumMatrix. update(row, col, val) sets a cell. sumRegion(r1, c1, r2, c2) is inclusive. Sample rectangle 8, then update(3,2,2) → 10. Up to 200 by 200; 5000 mixed calls.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '304 padded prefix rebuilt on update, or scan the rectangle each query', 'next' => 'wrong_static'],
                ['label' => 'Fenwick per row (or a 2-D BIT): delta on update, prefix sums on the box', 'next' => 'fenwick'],
            ],
        ],
        'wrong_static' => [
            'message' => "You are wrong here.\n304 has no updates. Scanning a 200 by 200 box 5000 times is too slow.\nStep back to when you reused a static prefix or a live nested loop.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'fenwick' => [
            'message' => "Doocs Solution 1: one Binary Indexed Tree per row, like 307. update: delta is val minus the current cell, then point-update that row at col+1. sumRegion: for each row in [r1, r2], add query(c2+1) minus query(c1). Update O(log n); query O(m log n), fine at m ≤ 200. A nested 2-D BIT is log m times log n both ways.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stay 0-indexed, or add val without subtracting the old cell', 'next' => 'wrong_idx'],
                ['label' => 'O(m n log n) build. Not a full scan of the box', 'next' => 'cpx'],
            ],
        ],
        'wrong_idx' => [
            'message' => "You are wrong. Fenwick is 1-indexed. Adding val without a delta double-counts.\nStep back to when you off-by-oned the tree or skipped the delta.",
            'outcome' => 'wrong',
            'rewind_to' => 'fenwick',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "307 is 1-D mutable. 304 is 2-D immutable. Inclusive corners.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Per-row Fenwick or 2-D BIT. Not 304, not a nested loop over the rectangle', 'next' => 'success'],
                ['label' => 'sumRegion is exclusive on r2/c2, like a Python slice', 'next' => 'wrong_excl'],
            ],
        ],
        'wrong_excl' => [
            'message' => "You are wrong. The rectangle includes (r2, c2).\nStep back to when you treated the far corner as exclusive.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Fenwick per row (or 2-D BIT). Update a delta. Rectangle is row prefixes. Not a rebuilt 304 prefix.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
