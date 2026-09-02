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
            'message' => "Problem: merge k sorted lists. [[1,4,5],[1,3,4],[2,6]] → [1,1,2,3,4,4,5,6]. k up to 10^4, total nodes n ≤ 10^4. Empty lists happen.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Each step scan all k heads and pick the min — O(k) per node', 'next' => 'scan_k'],
                ['label' => 'Put every nonempty head in a min-heap of size k; pop min, push its next', 'next' => 'heap'],
            ],
        ],
        'scan_k' => [
            'message' => "O(n k) is too slow when k and n are both 10^4. You only need the current minimum among k heads, which a heap finds in log k.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Concatenate every list then sort the nodes by value', 'next' => 'wrong_sort'],
                ['label' => 'Min-heap of heads; dummy tail; after popping u, if u.next exists push it', 'next' => 'heap'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong here.\nDumping into an array and sorting ignores that each list is already sorted and costs extra space plus O(n log n), worse than O(n log k) when k is small.\nStep back to when you chose how to pick the next node.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan_k',
            'choices' => [],
        ],
        'heap' => [
            'message' => "Skip null heads when seeding the heap. Pop the smallest node, splice it onto a dummy tail, push node.next if it exists.\nWhy not push the entire remaining list as one heap entry?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The heap compares node values; only the current head of each list is a candidate', 'next' => 'example'],
                ['label' => 'Pushing a whole list lets the heap merge in O(k) because lists stay intact', 'next' => 'wrong_whole'],
            ],
        ],
        'wrong_whole' => [
            'message' => "You are wrong. A heap entry is one node. After you take a head, its successor becomes that list's new candidate.\nStep back to when you defined a heap item.",
            'outcome' => 'wrong',
            'rewind_to' => 'heap',
            'choices' => [],
        ],
        'example' => [
            'message' => "Heads 1, 1, 2 in the heap. Pop 1 (first list), push 4. Pop the other 1, push 3. Continue until the heap is empty. Divide-and-conquer pairwise merge is also O(n log k).\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n log k) time, O(k) extra for the heap', 'next' => 'success'],
                ['label' => 'O(n) time because each node is visited once and the heap is free', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. Each of the n pops/pushes costs O(log k). The log k factor is the point of the heap.\nStep back to when you scored the heap.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Min-heap of up to k heads. Dummy tail: pop min, attach, push next. Time O(n log k), space O(k). Pairwise merge is the same bound without a heap.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
