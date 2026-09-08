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
            'message' => "Problem: numCourses labeled 0..n−1. Pair [a, b] means take b before a. Return true if you can finish every course. [[1,0]] → true. [[1,0],[0,1]] → false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat the graph as undirected, or emit a full order like Course Schedule II', 'next' => 'undir'],
                ['label' => 'Directed edges b→a; Kahn: peel in-degree 0; leftover nodes mean a cycle', 'next' => 'kahn'],
            ],
        ],
        'undir' => [
            'message' => "Undirected BFS would not see the 2-cycle 0⇄1 as blocked. Course Schedule II returns an order; this problem is only a boolean. Reverse Linked List rewires next, not a DAG.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Basic Calculator II: fold times/divide on a stack', 'next' => 'wrong_calc'],
                ['label' => 'g[b].append(a), indeg[a] += 1; queue zeros; if every course peels, true', 'next' => 'kahn'],
            ],
        ],
        'wrong_calc' => [
            'message' => "You are wrong here.\nCalculator II evaluates an arithmetic string. This is a directed cycle check.\nStep back to when you reused the calculator.",
            'outcome' => 'wrong',
            'rewind_to' => 'undir',
            'choices' => [],
        ],
        'kahn' => [
            'message' => "While the queue is nonempty: pop i, remaining -= 1, drop indeg of neighbors, enqueue at 0. Return remaining == 0. DFS twin: a back edge onto the recursion stack is a cycle.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[[1,0]] is true; [[1,0],[0,1]] is false', 'next' => 'cpx'],
                ['label' => 'Flip the pair: [a, b] means a before b, so [[1,0]] is a cycle', 'next' => 'wrong_dir'],
            ],
        ],
        'wrong_dir' => [
            'message' => "You are wrong. [a, b] is take b first, then a. [[1,0]] is 0 then 1, which is possible.\nStep back to when you reversed the arrow.",
            'outcome' => 'wrong',
            'rewind_to' => 'kahn',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n + m). Space O(n + m). Return a boolean, not the order.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Kahn until empty leftover; not undirected, not an order list, not 224/227', 'next' => 'success'],
                ['label' => 'A leftover node is fine if at least one course was taken', 'next' => 'wrong_left'],
            ],
        ],
        'wrong_left' => [
            'message' => "You are wrong. Every course must finish. Any leftover in-degree is a cycle; return false.\nStep back to when you allowed leftovers.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Arrow b→a. Kahn peels in-degree 0. Remaining 0 means no cycle. O(n + m). Not undirected, not Course Schedule II’s order, not a calculator, not Reverse List.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
