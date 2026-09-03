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
            'message' => "Problem: perfect binary tree. Set each next to the node on its right on the same level; last in a row → None. [1,2,3,4,5,6,7] serializes as [1,#,2,3,#,4,5,6,7,#]. Empty → [].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Flatten into a preorder right spine, or return Level Order’s nested value lists', 'next' => 'flat'],
                ['label' => 'BFS: snapshot the queue size; walk the row left to right, setting prev.next = node', 'next' => 'bfs'],
            ],
        ],
        'flat' => [
            'message' => "Flatten 114 makes a preorder list on .right. Level Order returns [[1],[2,3],…]. Here you keep the tree and fill .next across siblings (and across 2→3, 5→6).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Distinct Subsequences counting string ways, or Unique Paths', 'next' => 'wrong_dp'],
                ['label' => 'While q: p=None; for n in len(q): popleft; if p: p.next=node; p=node; enqueue left then right', 'next' => 'bfs'],
            ],
        ],
        'wrong_dp' => [
            'message' => "You are wrong here.\nThose are counts. This mutates next pointers and returns the same root.\nStep back to when you reused a counting DP.",
            'outcome' => 'wrong',
            'rewind_to' => 'flat',
            'choices' => [],
        ],
        'bfs' => [
            'message' => "Reset p at the start of each level so the last node of a row stays next=None (the #). Time O(n).\nWhy snapshot n = len(q) instead of draining until empty in one inner loop?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Children join the queue during the row; n is only this level, so 2.next is 3, not 4', 'next' => 'ret'],
                ['label' => 'One inner loop until empty — same as Flatten’s while root.right walk', 'next' => 'wrong_drain'],
            ],
        ],
        'wrong_drain' => [
            'message' => "You are wrong. Draining the whole queue would chain 2.next=3.next=4… across levels. The serialization needs # between rows.\nStep back to when you ignored levels.",
            'outcome' => 'wrong',
            'rewind_to' => 'bfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return root (or None). The tree is already linked. This problem’s tree is perfect; the next problem drops that.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The same root, not a boolean and not nested integer lists', 'next' => 'success'],
                ['label' => 'The integer Distinct Subsequences count f[m][n]', 'next' => 'wrong_count'],
            ],
        ],
        'wrong_count' => [
            'message' => "You are wrong. The judge wants the mutated tree, not a number.\nStep back to when you returned a count.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. BFS per level; prev.next = current; enqueue left then right. Empty → None. O(n). Not Flatten’s preorder spine, not Level Order lists, not Distinct Subsequences, not Unique Paths.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
