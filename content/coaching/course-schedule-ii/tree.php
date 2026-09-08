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
            'message' => "Problem: numCourses labeled 0..n−1. Pair [a, b] means take b before a. Return any valid order of all courses, or [] if a cycle. [[1,0]] → [0,1]. [[1,0],[2,0],[3,1],[3,2]] → [0,2,1,3] or [0,1,2,3]. One course, no edges → [0].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Same as Course Schedule: return true/false; any permutation of 0..n−1 is fine', 'next' => 'bool'],
                ['label' => 'Kahn: peel in-degree 0, append each popped course; length n or return empty', 'next' => 'kahn'],
            ],
        ],
        'bool' => [
            'message' => "Course Schedule (207) is only a boolean. Here the judge wants the order. A random permutation can violate an edge. Minimum Size Subarray Sum shrinks a numeric window, not a DAG.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Grow r, shrink l while the sum is ≥ target; return the shortest length', 'next' => 'wrong_win'],
                ['label' => 'g[b].append(a), indeg[a] += 1; queue zeros; ans.append(i) on pop; len(ans)==n else []', 'next' => 'kahn'],
            ],
        ],
        'wrong_win' => [
            'message' => "You are wrong here.\nA sliding window is Minimum Size Subarray Sum. This is a directed peel order.\nStep back to when you reused the window.",
            'outcome' => 'wrong',
            'rewind_to' => 'bool',
            'choices' => [],
        ],
        'kahn' => [
            'message' => "While the queue is nonempty: pop i, append i, drop indeg of neighbors, enqueue at 0. If ans is shorter than n, a leftover in-degree is a cycle — return []. DFS twin: finish-stack reversed, back edge → empty.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[[1,0]] is [0,1]; a 2-cycle returns []; one course is [0]', 'next' => 'cpx'],
                ['label' => 'Flip the pair: [a, b] means a before b, so [[1,0]] is [1,0]', 'next' => 'wrong_dir'],
            ],
        ],
        'wrong_dir' => [
            'message' => "You are wrong. [a, b] is take b first, then a. [[1,0]] is 0 then 1.\nStep back to when you reversed the arrow.",
            'outcome' => 'wrong',
            'rewind_to' => 'kahn',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n + m). Space O(n + m). Return a list of length n, or empty — not a boolean.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Kahn peel into ans; full n or []; not 207’s boolean, not a window, not a reversed pair', 'next' => 'success'],
                ['label' => 'A partial prefix is enough if at least one course was taken', 'next' => 'wrong_part'],
            ],
        ],
        'wrong_part' => [
            'message' => "You are wrong. The order must include every course. A leftover in-degree means return [].\nStep back to when you kept a prefix.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Arrow b→a. Kahn peels in-degree 0 and records the order. Length n, else empty. O(n + m). Not Course Schedule’s boolean, not a sliding window, not a reversed pair, not a partial prefix.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
