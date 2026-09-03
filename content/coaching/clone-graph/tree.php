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
            'message' => "Problem: deep-copy a connected undirected graph. [[2,4],[1,3],[2,4],[1,3]] clones 4 nodes with the same edges. [] → None. A lone node clones with empty neighbors.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reuse the same Node objects (shallow), Same Tree’s binary recursion, or Surrounded Regions’ grid DFS', 'next' => 'shallow'],
                ['label' => 'Hash map original→clone; DFS creates a node, stores it, then clones neighbors', 'next' => 'dfs'],
            ],
        ],
        'shallow' => [
            'message' => "A shallow copy still points at the original neighbors. Same Tree is binary. Grid DFS walks cells, not Node.neighbors.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Word Ladder’s string BFS, or return the adjacency list as nested Python lists', 'next' => 'wrong_other'],
                ['label' => 'if node in g: return g[node]; clone = Node(val); g[node]=clone; then append dfs of each neighbor', 'next' => 'dfs'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nThe return type is a Node, not an adj-list of ints. Word Ladder is a different graph.\nStep back to when you copied those APIs.",
            'outcome' => 'wrong',
            'rewind_to' => 'shallow',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Register the clone in the map before walking neighbors. Time O(n). Empty input: node is None, return None.\nWhy store the clone before the neighbor loop?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The graph has cycles; without the map hit, DFS would recurse forever on a back-edge', 'next' => 'ret'],
                ['label' => 'Order does not matter; you can clone neighbors first and put the node in the map last', 'next' => 'wrong_cycle'],
            ],
        ],
        'wrong_cycle' => [
            'message' => "You are wrong. 1→2→1 would call dfs(1) again before 1 is stored, and never return.\nStep back to when you mapped after the neighbor walk.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return the cloned start node (dfs(node)). Neighbors on the copy must be copies, not originals.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The new Node with val 1 whose neighbor list holds the other clones — not the original pointers', 'next' => 'success'],
                ['label' => 'The same node object that was passed in', 'next' => 'wrong_same'],
            ],
        ],
        'wrong_same' => [
            'message' => "You are wrong. Returning the input is not a deep copy. Judges check identity of nodes.\nStep back to when you returned the original.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Map old→new, DFS, store before neighbors. None in, None out. O(n). Not a shallow copy, not Same Tree, not Surrounded Regions, not Word Ladder, not an adj-list of ints.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
