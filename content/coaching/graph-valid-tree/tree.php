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
            'message' => "Problem: n nodes 0..n−1, undirected edges. True iff they form a tree. n=5, [[0,1],[0,2],[0,3],[1,4]] is true. Extra [1,3] is a cycle, false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Course Schedule (207): directed Kahn / leftover nodes; or Zigzag Iterator on the edge list', 'next' => 'dir'],
                ['label' => 'Union-find: same-set edge is a cycle; else merge and decrement components; true iff one component remains', 'next' => 'uf'],
            ],
        ],
        'dir' => [
            'message' => "207 is a DAG check. This graph is undirected. A tree is connected and acyclic (equivalently n−1 edges and one component).\nHow does DFS go wrong without the edge count?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A connected cyclic graph still visits every node. Require len(edges) == n−1, then DFS/BFS from 0 visits all', 'next' => 'uf'],
                ['label' => 'Treat edges as one-way and run topological sort', 'next' => 'wrong_topo'],
            ],
        ],
        'wrong_topo' => [
            'message' => "You are wrong here.\nUndirected [a,b] is both ways. Kahn on a directed version does not test a tree.\nStep back to when you directed the edges.",
            'outcome' => 'wrong',
            'rewind_to' => 'dir',
            'choices' => [],
        ],
        'uf' => [
            'message' => "find with path compression. If find(a)==find(b), false. Else p[pa]=pb and n -= 1. After all edges, n==1.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'n=5, four star edges → true; the five-edge cycle example → false', 'next' => 'cpx'],
                ['label' => 'Skip the component check: no cycle is enough even if two components remain', 'next' => 'wrong_disc'],
            ],
        ],
        'wrong_disc' => [
            'message' => "You are wrong. A forest of two trees is acyclic but not one tree. You need a single component.\nStep back to when you dropped connectivity.",
            'outcome' => 'wrong',
            'rewind_to' => 'uf',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n log n) union-find or O(n) DFS. Not Course Schedule, not zigzag of edges, not visit-all without n−1.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'No cycle and one component (or n−1 edges plus a full visit from 0)', 'next' => 'success'],
                ['label' => 'Number of Islands: count components and return true if the count is n', 'next' => 'wrong_isl'],
            ],
        ],
        'wrong_isl' => [
            'message' => "You are wrong. Islands count grid 1-components. A tree needs exactly one component and no cycle.\nStep back to when you counted islands.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Union-find: same-set edge is a cycle; else merge. Finish with one component. DFS twin: n−1 edges and every node reachable from 0. Do not treat edges as directed or skip the connectivity check.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
