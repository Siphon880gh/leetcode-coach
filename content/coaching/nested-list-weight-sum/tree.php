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
            'message' => "Problem: nested list; each item is an integer or another list. Depth of an integer is how many lists wrap it; the input list is depth 1. Sum value × depth. [[1,1],2,[1,1]] → 10. [1,[4,[6]]] → 27.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Start depth at 0, or invert like Nested List Weight Sum II (364)', 'next' => 'wrong_364'],
                ['label' => 'DFS from depth 1: integer × depth, recurse lists at depth+1', 'next' => 'dfs'],
            ],
        ],
        'wrong_364' => [
            'message' => "You are wrong here. Depth 0 zeros the top level. 364 weights by maxDepth minus depth; this problem uses raw depth from the outside in.\nStep back to when you started at 0 or inverted the weights.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "If item.isInteger(), add getInteger() × depth. Else add dfs(getList(), depth+1). Empty lists add 0. BFS twin: queue (item, depth) and enqueue children at depth+1.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Flatten first then multiply every integer by 1 (or treat 341 as this problem)', 'next' => 'wrong_flat'],
                ['label' => 'O(N) over every integer and list node; D ≤ 50', 'next' => 'cpx'],
            ],
        ],
        'wrong_flat' => [
            'message' => "You are wrong. Flattening drops nesting, so every integer would look like depth 1. 341 is an iterator, not a weighted sum.\nStep back to when you flattened or reached for 341.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "The answer is the weighted sum, not the max depth.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DFS depth 1. Value × depth. Not 364', 'next' => 'success'],
                ['label' => 'Return the maximum depth instead of the weighted sum', 'next' => 'wrong_max'],
            ],
        ],
        'wrong_max' => [
            'message' => "You are wrong. The judge wants sum of integer × depth, not how deep the nesting goes.\nStep back to when you returned max depth.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. DFS from depth 1: integers × depth, lists recurse at depth+1. Not 364 inverted weights.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
