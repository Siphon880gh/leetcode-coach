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
            'message' => "Problem: NestedInteger (integer or list). Depth is how many lists wrap an integer (outer is 1). Weight is maxDepth − depth + 1 (shallow integers weigh more). Return sum of value × weight. [[1,1],2,[1,1]] → 8. [1,[4,[6]]] → 17. No empty lists. Depth at most 50.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Use raw depth as the weight (the 339 formula)', 'next' => 'wrong_339'],
                ['label' => 'DFS: track maxDepth, s (sum of values), and ws (value × depth). Answer (maxDepth + 1) × s − ws', 'next' => 'dfs'],
            ],
        ],
        'wrong_339' => [
            'message' => "You are wrong here. 339 would score the first example as 10. Here the four 1s weigh 1 and the 2 weighs 2, total 8.\nStep back to when you used Nested List Weight Sum (339).",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Start each top-level element at depth 1. Integers update maxDepth, s, and ws. Lists recurse at depth+1. Weight × value equals (maxDepth + 1) × value minus value × depth, so one pass is enough.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Flatten first, then multiply every integer by 1, or start depth at 0', 'next' => 'wrong_flat'],
                ['label' => 'Keep nested structure. Depth starts at 1. Optional BFS: integers per level, then invert with maxDepth', 'next' => 'kind'],
            ],
        ],
        'wrong_flat' => [
            'message' => "You are wrong. Flattening drops nesting, so every integer looks like depth 1. Depth 0 would off-by-one the weights.\nStep back to when you flattened or started at 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'kind' => [
            'message' => "[1,[4,[6]]]: maxDepth 3, 1 weighs 3, 4 weighs 2, 6 weighs 1, total 17. BFS summing per level then weighting d by maxDepth − d + 1 matches.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Invert with maxDepth. One DFS identity, or BFS levels. Not 339, not flatten', 'next' => 'success'],
                ['label' => 'Weight with depth / maxDepth as a fraction, or skip seeding depth 1 on the outer list', 'next' => 'wrong_frac'],
            ],
        ],
        'wrong_frac' => [
            'message' => "You are wrong. Weight is maxDepth − depth + 1, an integer. The outer list is depth 1 by definition.\nStep back to when you used a ratio or skipped the outer depth.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Weight is maxDepth − depth + 1. Answer (maxDepth + 1) × s − ws. [[1,1],2,[1,1]] → 8. Not 339.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
