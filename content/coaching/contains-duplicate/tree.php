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
            'message' => "Problem: true if any value in nums appears at least twice, else false. n ≤ 10⁵. [1,2,3,1] → true. [1,2,3,4] → false. [1,1,1,3,3,4,3,2,4,2] → true.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Nested every pair, or require the two copies to be at most k apart (Contains Duplicate II)', 'next' => 'nested'],
                ['label' => 'Seen set: hit → true, else insert. Twin: sort and compare adjacent', 'next' => 'set'],
            ],
        ],
        'nested' => [
            'message' => "O(n²) pairs time out at 10⁵. II needs |i−j| ≤ k. III needs a value window. Delete Node in a Linked List copies next — a list, not an array scan.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy node.next.val into node, then skip node.next', 'next' => 'wrong_del'],
                ['label' => 'Any second copy anywhere: hash set, or sort then equal neighbors. Boolean only', 'next' => 'set'],
            ],
        ],
        'wrong_del' => [
            'message' => "You are wrong here.\nCopy-next deletes a list node. This is an array duplicate check.\nStep back to when you reused delete-node.",
            'outcome' => 'wrong',
            'rewind_to' => 'nested',
            'choices' => [],
        ],
        'set' => [
            'message' => "Walk left to right. If x is in the set, true; else add x. After the loop, false. len(set) < n is the same test. Sort in place then scan neighbors for O(1) extra.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,2,3,1] true; [1,2,3,4] false; the long sample with many 1s/3s/4s/2s true', 'next' => 'cpx'],
                ['label' => 'Only consecutive duplicates in the original array count, so [1,2,3,1] is false', 'next' => 'wrong_adj'],
            ],
        ],
        'wrong_adj' => [
            'message' => "You are wrong. The copies need not be neighbors in the original order. [1,2,3,1] is true.\nStep back to when you required consecutive originals.",
            'outcome' => 'wrong',
            'rewind_to' => 'set',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Set: O(n) time, O(n) extra. Sort: O(n log n) time, O(1) extra if in place. Return a boolean, not indices.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Seen set or sorted neighbors; not nested pairs, not II’s window k, not a list delete', 'next' => 'success'],
                ['label' => 'Return the duplicated value, or the two indices, like Two Sum', 'next' => 'wrong_ret'],
            ],
        ],
        'wrong_ret' => [
            'message' => "You are wrong. The judge wants true or false, not a value or a pair of indices.\nStep back to when you returned extra data.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Any second copy anywhere. Hash set (or sort then adjacent). O(n) / O(n log n). Not nested pairs, not Contains Duplicate II’s distance k, not III’s value window, not delete-node, not Two Sum’s indices.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
