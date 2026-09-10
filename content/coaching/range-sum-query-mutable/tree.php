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
            'message' => "Problem: NumArray. update(index, val) sets nums[index]. sumRange(left, right) is inclusive. [1,3,5] → sum 9; update(1, 2) → sum 8. Length and call count up to 3e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '303 static prefix rebuilt on every update, or scan left..right each query', 'next' => 'wrong_static'],
                ['label' => 'Fenwick (or segment tree): 1-indexed prefixes, O(log n) update and range', 'next' => 'fenwick'],
            ],
        ],
        'wrong_static' => [
            'message' => "You are wrong here.\n303 has no updates. Rebuilding a prefix or scanning the range is O(n) per call and fails 3e4 mixed calls.\nStep back to when you reused a static prefix or a live loop.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'fenwick' => [
            'message' => "Tree c[1 .. n]. update(x, delta): add delta to c[x], jump x by lowbit. query(x): sum while x > 0, subtract lowbit. Inclusive range = query(right+1) minus query(left). On update(i, val), delta is val minus the current nums[i] (keep a copy, or sumRange(i, i)). Build by point-updating each value.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stay 0-indexed (forget index+1), or add val instead of val minus old', 'next' => 'wrong_idx'],
                ['label' => 'O(n log n) build, O(log n) per update / sumRange', 'next' => 'cpx'],
            ],
        ],
        'wrong_idx' => [
            'message' => "You are wrong. Fenwick is 1-indexed. Adding val without subtracting the old value double-counts.\nStep back to when you off-by-oned the tree or skipped the delta.",
            'outcome' => 'wrong',
            'rewind_to' => 'fenwick',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "A segment tree is also valid. Doocs Solution 1 is Fenwick. 304/308 are 2-D.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Fenwick prefix, delta on update, query(right+1) minus query(left). Not 303', 'next' => 'success'],
                ['label' => 'sumRange is exclusive on the right, like Python slices', 'next' => 'wrong_excl'],
            ],
        ],
        'wrong_excl' => [
            'message' => "You are wrong. The range is inclusive on both ends. right is in the sum.\nStep back to when you treated it as exclusive.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. 1-indexed Fenwick. update adds a delta. Inclusive sum is query(right+1) minus query(left). O(log n). Not a rebuilt 303 prefix.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
