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
            'message' => "Problem: merge two sorted lists. [1,2,4] and [1,3,4] → [1,1,2,3,4,4]. Splice existing nodes; empty list is a valid head.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Walk list1 to its tail, then set that tail.next to list2', 'next' => 'concat'],
                ['label' => 'Always splice the smaller current head, recursively or with a dummy tail', 'next' => 'merge'],
            ],
        ],
        'concat' => [
            'message' => "1-2-4-1-3-4 is not sorted. You must pick the min of the two heads at every step, then attach the leftover list at the end.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy every value into an array, sort, and build a new list', 'next' => 'wrong_copy'],
                ['label' => 'If one list is null, return the other. Else attach min(l1, l2) and recurse on that next pointer', 'next' => 'merge'],
            ],
        ],
        'wrong_copy' => [
            'message' => "You are wrong here.\nThe problem asks you to splice the given nodes, not allocate a fresh list of copied values.\nStep back to when you chose how to reuse nodes.",
            'outcome' => 'wrong',
            'rewind_to' => 'concat',
            'choices' => [],
        ],
        'merge' => [
            'message' => "Recursive: if l1 is null or l2 is null, return the other. If l1.val <= l2.val, l1.next = merge(l1.next, l2), return l1; else the symmetric case. Dummy walk is the same choice in a loop.\nWhen one list runs out, what happens?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The remaining list is already sorted — hang it off the current tail (or return it as the base case)', 'next' => 'example'],
                ['label' => 'Stop and return dummy.next, dropping whatever is left on the other list', 'next' => 'wrong_drop'],
            ],
        ],
        'wrong_drop' => [
            'message' => "You are wrong. The leftover nodes still belong in the answer. Base case: return the nonempty list.\nStep back to when you handled a null head.",
            'outcome' => 'wrong',
            'rewind_to' => 'merge',
            'choices' => [],
        ],
        'example' => [
            'message' => "Heads 1 and 1: keep the first 1, merge [2,4] with [1,3,4]. Next pick 1 from list2, then 2, 3, 4, 4.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(m + n) time; recursion uses O(m + n) stack, dummy iteration uses O(1) extra', 'next' => 'success'],
                ['label' => 'O(min(m, n)) because you stop when the shorter list ends', 'next' => 'wrong_min'],
            ],
        ],
        'wrong_min' => [
            'message' => "You are wrong. You still walk every leftover node on the longer list. The work is linear in both lengths.\nStep back to when you scored the merge.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Base: a null list returns the other. Else splice the smaller head and merge the rest (recursion or dummy + tail). Time O(m + n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
