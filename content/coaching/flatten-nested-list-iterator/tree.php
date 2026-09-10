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
            'message' => "Problem: NestedInteger is an integer or a list of NestedInteger. Build NestedIterator: next returns the next integer left to right; hasNext is true while any integer remains. [[1,1],2,[1,1]] → [1,1,2,1,1]. [1,[4,[6]]] → [1,4,6]. Do not implement NestedInteger yourself.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Weighted sum like Nested List Weight Sum (339), or write NestedInteger yourself', 'next' => 'wrong_339'],
                ['label' => 'Emit flattened integers: DFS a flat array, or a stack that peels lists', 'next' => 'iter'],
            ],
        ],
        'wrong_339' => [
            'message' => "You are wrong here. 339 sums value × depth. This problem only walks integers in order. NestedInteger is given; you must not reimplement it.\nStep back to when you treated this as 339 or wrote NestedInteger.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'iter' => [
            'message' => "Constructor DFS: if x.isInteger(), append getInteger(); else recurse getList(). Store nums and an index. hasNext is index+1 still in range. Lazy twin: push input reversed; hasNext peels list tops (children reversed) until an integer sits on top; next pops it.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Call getInteger on a list, or skip hasNext before next', 'next' => 'wrong_api'],
                ['label' => 'Empty lists add nothing. Tester always calls hasNext before next', 'next' => 'cpx'],
            ],
        ],
        'wrong_api' => [
            'message' => "You are wrong. getInteger on a list is undefined. The tester always calls hasNext first; next must not guess when the stream is empty.\nStep back to when you mixed the API or skipped hasNext.",
            'outcome' => 'wrong',
            'rewind_to' => 'iter',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(N) over every integer and list node (constructor DFS, or amortized in hasNext). Space O(N) for the flat array, or O(D) for the lazy stack.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DFS flatten or lazy stack. Emit values. Not 339', 'next' => 'success'],
                ['label' => 'Yield empty lists as 0, or return the nested structure unchanged', 'next' => 'wrong_empty'],
            ],
        ],
        'wrong_empty' => [
            'message' => "You are wrong. Empty lists contribute no integers. The output is a flat sequence of ints, not the original nesting.\nStep back to when you emitted 0 for empty lists or kept the nested shape.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. DFS flatten or a lazy stack. Integers in order. Not 339 weighted sum.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
