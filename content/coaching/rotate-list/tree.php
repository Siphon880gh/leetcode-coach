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
            'message' => "Problem: rotate a linked list right by k. [1,2,3,4,5], k=2 → [4,5,1,2,3]. k can be 2e9. Empty or one node stays. n ≤ 500.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse rows then transpose — that is Rotate Image on a matrix', 'next' => 'image'],
                ['label' => 'Count n, k %= n; fast walks k; then both until fast.next is null; splice new head', 'next' => 'gap'],
            ],
        ],
        'image' => [
            'message' => "This is a singly linked list, not an n×n grid. Right-rotate means the last k nodes move to the front.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse the whole list, then reverse the first k nodes like Reverse Nodes in k-Group', 'next' => 'wrong_rev'],
                ['label' => 'k %= n; a k-gap finds the cut: new head is slow.next, old tail links to old head', 'next' => 'gap'],
            ],
        ],
        'wrong_rev' => [
            'message' => "You are wrong here.\nFull reverse changes 1-2-3-4-5 into 5-4-3-2-1, which is not a right rotate by 2. k-Group reverses windows, it does not cycle the list.\nStep back to when you reversed.",
            'outcome' => 'wrong',
            'rewind_to' => 'image',
            'choices' => [],
        ],
        'gap' => [
            'message' => "Why k %= n before moving the fast pointer?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'k can be 2e9; n full turns are a no-op, so only the remainder matters', 'next' => 'example'],
                ['label' => 'Walk k nodes from the head k times; modulo is optional because n is tiny', 'next' => 'wrong_mod'],
            ],
        ],
        'wrong_mod' => [
            'message' => "You are wrong. Walking 2e9 steps TLE. After counting n, reduce k. If k becomes 0, return head.\nStep back to when you skipped the modulo.",
            'outcome' => 'wrong',
            'rewind_to' => 'gap',
            'choices' => [],
        ],
        'example' => [
            'message' => "Fast starts k ahead. Joint walk stops when fast.next is null, so slow sits just before the new head. Cut slow.next, hang old head off fast.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(1) extra', 'next' => 'success'],
                ['label' => 'O(n) extra: copy values into an array, rotate the array, rebuild the list', 'next' => 'wrong_arr'],
            ],
        ],
        'wrong_arr' => [
            'message' => "You are wrong. The writeup only rewires three pointers after one count plus one gap walk. No array copy.\nStep back to when you allocated the array.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. If n < 2 return head. k %= n; if 0 return head. Fast k steps, then both until fast.next is null. New head = slow.next; slow.next = null; fast.next = old head. Time O(n). Not Rotate Image, and not Reverse Nodes in k-Group.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
