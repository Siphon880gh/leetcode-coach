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
            'message' => "Problem: exactly two values appear once; the rest twice. Return those two in linear time and constant extra space. [1,2,1,3,2,5] → [3,5].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hash-count leftovers, or Single Number (136): XOR all and return that one leftover', 'next' => 'hash'],
                ['label' => 'XOR all into xs (= a XOR b); lb = xs AND (−xs); XOR the bit-set group; b = xs XOR a', 'next' => 'xor'],
            ],
        ],
        'hash' => [
            'message' => "A map is O(n) extra. 136 has one leftover; here xs is a XOR b, not a single answer. Because a ≠ b, xs has a bit set.\nHow do you split a from b?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'lowbit is a bit where they differ. XOR values with that bit into a; pairs in that group still cancel', 'next' => 'xor'],
                ['label' => 'Sort and scan adjacent equals; report values that appear once', 'next' => 'wrong_sort'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong here.\nSort is O(n log n). The bound is linear time and O(1) extra.\nStep back to when you sorted.",
            'outcome' => 'wrong',
            'rewind_to' => 'hash',
            'choices' => [],
        ],
        'xor' => [
            'message' => "[1,2,1,3,2,5]: xs = 3 XOR 5. One group XOR is 3, the other is 5. Return any order.\nWhich follow-up?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(1) extra; two passes', 'next' => 'cpx'],
                ['label' => 'Wiggle Sort: swap adjacent pairs on the XOR mask', 'next' => 'wrong_wig'],
            ],
        ],
        'wrong_wig' => [
            'message' => "You are wrong. Wiggle Sort rearranges a wave. This problem recovers two unique numbers.\nStep back to when you swapped problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'xor',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Not a hash, not return xs, not Single Number II’s threes. b is xs XOR a so you never XOR the other group by hand.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'XOR all, split on lowbit, XOR one group, other is xs XOR a', 'next' => 'success'],
                ['label' => 'Return xs as both answers', 'next' => 'wrong_xs'],
            ],
        ],
        'wrong_xs' => [
            'message' => "You are wrong. xs is a XOR b, not a or b (unless one is 0 and you still need both).\nStep back to when you returned the combined XOR.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. xs = XOR of all. lb = xs AND (−xs). XOR numbers with that bit into a. b = xs XOR a. Do not hash, sort, or return the combined XOR as the pair.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
