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
            'message' => "Problem: n nodes 0..n−1, undirected edges [a, b]. Count connected components. n=5, [[0,1],[1,2],[3,4]] → 2. Isolated vertices count. No self-loops or duplicate edges.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat as a grid (200), a directed graph (207), or require a tree (261)', 'next' => 'wrong_model'],
                ['label' => 'Undirected adj list: each unvisited start is +1, or union-find from n', 'next' => 'dfs'],
            ],
        ],
        'wrong_model' => [
            'message' => "You are wrong here.\n200 floods a grid. 207 is directed. 261 needs one component and n−1 edges. Here you only count pieces of an undirected graph.\nStep back to when you picked the wrong graph model.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Build undirected g[a]↔g[b]. vis empty. For each i, if not visited, DFS/BFS the component and add 1. Isolated nodes never appear in edges but still start a walk that returns 1.\nUnion-find: ans = n; union only decrements when roots differ.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'One-way edges, skip isolates, or decrement ans when already same parent', 'next' => 'wrong_trap'],
                ['label' => 'O(n + m). Count components, not a tree check', 'next' => 'cpx'],
            ],
        ],
        'wrong_trap' => [
            'message' => "You are wrong. Directed edges split components. Isolates still count. Same-parent unions must not decrement ans.\nStep back to when you directed the edges, dropped isolates, or always subtracted.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n + m) DFS/BFS, or O(n + m α(n)) union-find. Space O(n + m).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Undirected walk or merge-count. Isolates count. Not 200, not 261', 'next' => 'success'],
                ['label' => 'Return n minus the number of edges', 'next' => 'wrong_nm'],
            ],
        ],
        'wrong_nm' => [
            'message' => "You are wrong. Extra edges inside a component do not create or destroy pieces. n minus m is not the component count.\nStep back to when you subtracted the edge count.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Each unvisited start is a component, or union-find starts at n and decrements on a real merge. Isolated nodes count. Undirected only.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
