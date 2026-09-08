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
            'message' => "Problem: buildings [left, right, height] on the ground. Return contour key points sorted by x: left of each horizontal run, last y is 0. No consecutive equal heights. Sample → [[2,10],[3,15],[7,12],[12,0],[15,10],[20,8],[24,0]]. Two abutting height-3 blocks → [[0,3],[5,0]].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Merge Intervals on [left, right], or prefix times suffix like Product of Array Except Self', 'next' => 'merge'],
                ['label' => 'Sweep every left/right x; max-heap of live buildings; emit [x, h] only when height changes', 'next' => 'sweep'],
            ],
        ],
        'merge' => [
            'message' => "Merge Intervals unions ranges, not max height. Product except self is an array product, not a skyline. Largest Rectangle in Histogram is bars, not overlapping [left, right] boxes.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Left-to-right prefix product, then right-to-left suffix into the same array', 'next' => 'wrong_prod'],
                ['label' => 'At each x, push starts, pop ended, live max (or 0); skip if that y equals the last emitted y', 'next' => 'sweep'],
            ],
        ],
        'wrong_prod' => [
            'message' => "You are wrong here.\nPrefix times suffix is Product of Array Except Self. This is a sweep of building edges.\nStep back to when you reused prefix products.",
            'outcome' => 'wrong',
            'rewind_to' => 'merge',
            'choices' => [],
        ],
        'sweep' => [
            'message' => "Sort all x. Heap holds (height, right). Lazy-pop while top.right ≤ x. Emit only on a height change. Touching same-height blocks must not dip to 0 at the joint.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The five-building sample matches the contour; [[0,2,3],[2,5,3]] is [[0,3],[5,0]]', 'next' => 'cpx'],
                ['label' => 'Emit a 0 at every building’s right edge, including x=2 between the two height-3 blocks', 'next' => 'wrong_dip'],
            ],
        ],
        'wrong_dip' => [
            'message' => "You are wrong. Consecutive equal heights merge. At x=2 the live max stays 3, so you skip.\nStep back to when you emitted the dip.",
            'outcome' => 'wrong',
            'rewind_to' => 'sweep',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n log n). Space O(n). Last point y is 0.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sweep x, heap of live max, emit on change; not merge-only, not prefix products, not a 0 dip at a same-height joint', 'next' => 'success'],
                ['label' => 'Output every building corner even when the max height does not change', 'next' => 'wrong_all'],
            ],
        ],
        'wrong_all' => [
            'message' => "You are wrong. Key points are only where the contour height changes. Consecutive equal y values are illegal.\nStep back to when you dumped every corner.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sweep every left/right x. Heap of live buildings, max height (or 0). Emit [x, h] only when h changes. No 0 between touching same-height blocks. O(n log n). Not Merge Intervals, not prefix products, not every corner.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
