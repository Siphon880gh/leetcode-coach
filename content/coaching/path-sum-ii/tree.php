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
            'message' => "Problem: return every root-to-leaf path whose values sum to targetSum. [5,4,8,11,null,13,4,7,2,null,null,5,1], 22 → [[5,4,11,2],[5,8,4,5]]. [1,2,3], 5 → []. Up to 5000 nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return Path Sum’s boolean, or Unique Paths counting grid walks', 'next' => 'bool'],
                ['label' => 'DFS with a path buffer: append, recurse, pop; copy the buffer at a matching leaf', 'next' => 'dfs'],
            ],
        ],
        'bool' => [
            'message' => "Path Sum I only asks whether one path exists. Unique Paths counts grid routes. Here you list every matching path of values.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Level Order nested rows, or Flatten Tree into a linked list', 'next' => 'wrong_flat'],
                ['label' => 't.append(val); if leaf and s==target, ans.append(t[:]); dfs both; then t.pop()', 'next' => 'dfs'],
            ],
        ],
        'wrong_flat' => [
            'message' => "You are wrong here.\nLevel Order is BFS rows. Flatten is a later problem that rewires pointers. This collects value lists along root-to-leaf paths.\nStep back to when you reused those problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'bool',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Time O(n²) because each matching path is copied. Empty or no match → [].\nWhy t[:] (a copy) instead of ans.append(t)?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 't is reused; without a copy, later pop() would mutate the stored path', 'next' => 'ret'],
                ['label' => 'Skip pop(); leave values on t so later siblings share the prefix', 'next' => 'wrong_pop'],
            ],
        ],
        'wrong_pop' => [
            'message' => "You are wrong. Without pop, t keeps growing across branches and paths mix. Backtracking needs append then pop.\nStep back to when you skipped pop.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return ans. Still only record at a leaf, same as Path Sum I.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A list of value-paths, not a boolean and not a rebuilt tree', 'next' => 'success'],
                ['label' => 'true/false like Path Sum I', 'next' => 'wrong_bool'],
            ],
        ],
        'wrong_bool' => [
            'message' => "You are wrong. The judge wants the actual paths, even when there are two of them.\nStep back to when you returned a boolean.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Backtracking DFS; copy t at a matching leaf; pop after both children. Empty → []. O(n²). Not Path Sum I’s boolean, not Unique Paths, not Level Order, not Flatten.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
