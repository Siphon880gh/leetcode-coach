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
            'message' => "Problem: kth largest in nums in sorted order, not kth distinct. 1 ≤ k ≤ n ≤ 10⁵. [3,2,1,5,6,4], k=2 → 5. [3,2,3,1,2,4,5,5,6], k=4 → 4 (descending 6, 5, 5, 4). Follow-up: without a full sort.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Drop duplicates then take the kth, or inorder a BST of the values', 'next' => 'wrongish'],
                ['label' => 'kth largest sits at index n−k after an ascending sort; Quickselect or a min-heap of size k', 'next' => 'qs'],
            ],
        ],
        'wrongish' => [
            'message' => "Duplicates count: two 5s both sit in the ranking. Kth Smallest in a BST walks a tree, not an unordered array. LCA of a BST walks until p and q split — unrelated.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'From the root, if both p and q are smaller go left; else if both larger go right', 'next' => 'wrong_lca'],
                ['label' => 'Partition toward n−k; recurse only that side. Twin: min-heap of size k, top is the answer', 'next' => 'qs'],
            ],
        ],
        'wrong_lca' => [
            'message' => "You are wrong here.\nLCA of a BST is a tree walk. This is selection on an array.\nStep back to when you reused LCA.",
            'outcome' => 'wrong',
            'rewind_to' => 'wrongish',
            'choices' => [],
        ],
        'qs' => [
            'message' => "Pick a pivot, Hoare-partition, look at the split. If it is left of n−k, search the right half; else the left. Average O(n). Heap: push, pop when size > k; top is kth largest, O(n log k).\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[3,2,1,5,6,4] k=2 is 5; second sample k=4 is 4, not 3', 'next' => 'cpx'],
                ['label' => 'k=2 means the 2nd distinct, so [3,2,1,5,6,4] is 4 after unique sort', 'next' => 'wrong_dist'],
            ],
        ],
        'wrong_dist' => [
            'message' => "You are wrong. It is sorted-order kth, not distinct. Unique-sort would change the second sample too.\nStep back to when you dropped duplicates.",
            'outcome' => 'wrong',
            'rewind_to' => 'qs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Quickselect average O(n), worst O(n²) unless you shuffle. Heap O(n log k) extra O(k). Do not return the kth smallest by forgetting n−k.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Index n−k, partition or min-heap k; not distinct ranks, not BST inorder, not LCA', 'next' => 'success'],
                ['label' => 'The kth largest is nums[k-1] after an ascending sort', 'next' => 'wrong_idx'],
            ],
        ],
        'wrong_idx' => [
            'message' => "You are wrong. Ascending sort puts the kth largest at index n−k, not k−1 (that is the kth smallest).\nStep back to when you used k−1.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sorted-order kth, not distinct. Quickselect at n−k, or a min-heap of size k. Average O(n) / O(n log k). Not unique ranks, not BST inorder, not LCA of a BST, not index k−1 in an ascending array.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
