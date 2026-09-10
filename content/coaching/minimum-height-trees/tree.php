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
            'message' => "Problem: n nodes 0 .. n−1, n−1 undirected edges forming a tree. Height is the longest downward path in edges from a chosen root. Return every root that achieves the minimum height. n=4, edges [[1,0],[1,2],[1,3]] → [1]. n=6 sample → [3,4]. n=1 → [0]. n up to 2e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DFS or BFS height from every node as root', 'next' => 'wrong_all'],
                ['label' => 'Peel degree-1 leaves inward; the last wave is the center', 'next' => 'peel'],
            ],
        ],
        'wrong_all' => [
            'message' => "You are wrong here.\nHeight from every root is O(n squared) and fails 2e4 nodes. The MHT roots are the 1 or 2 centroids.\nStep back to when you rooted at every node.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'peel' => [
            'message' => "If n==1 return [0]. Build adjacency and degree. Queue every degree-1 node. Each wave: clear ans, then for each node in the wave append it, decrement neighbors, enqueue when a neighbor’s degree becomes 1. When the queue drains, ans is the last wave (1 or 2 nodes).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return every node that was ever a leaf, or treat edges as directed', 'next' => 'wrong_leaf'],
                ['label' => 'O(n) time and space. Last remaining layer only', 'next' => 'cpx'],
            ],
        ],
        'wrong_leaf' => [
            'message' => "You are wrong. Early leaves are far from the center. The graph is undirected.\nStep back to when you kept the outer layers or directed the edges.",
            'outcome' => 'wrong',
            'rewind_to' => 'peel',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "One centroid if the diameter is odd; two adjacent if even. Any order is fine.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Peel leaves until one or two centroids remain. Not height from every node', 'next' => 'success'],
                ['label' => 'There can be many MHT roots, one per branch', 'next' => 'wrong_many'],
            ],
        ],
        'wrong_many' => [
            'message' => "You are wrong. A tree’s center is at most two nodes.\nStep back to when you allowed many roots.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Topo-peel from leaves. The last wave is the MHT roots. n=1 is [0]. Not O(n squared) from every root.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
