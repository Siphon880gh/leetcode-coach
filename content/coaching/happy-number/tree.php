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
            'message' => "Problem: is n happy? Replace n by the sum of its digit squares; true if you hit 1, false if you loop without 1. 19 → true (82, 68, 100, 1). 2 → false. 1 ≤ n ≤ 2³¹ − 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'AND the range [1, n], or recurse digit squares with no seen set', 'next' => 'other'],
                ['label' => 'While n is not 1 and n is new: insert n, then n = sum of digit squares; return n == 1', 'next' => 'vis'],
            ],
        ],
        'other' => [
            'message' => "Bitwise AND of a Range is two endpoints, not digit squares. Recursion without a set blows the stack on the unhappy cycle.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count Complete Tree Nodes: skip a perfect subtree with 2^h', 'next' => 'wrong_tree'],
                ['label' => 'Record seen values; 1 wins, a repeat is the 4-cycle and loses', 'next' => 'vis'],
            ],
        ],
        'wrong_tree' => [
            'message' => "You are wrong here.\nCount Complete Tree Nodes walks a complete binary tree. This is a number map.\nStep back to when you reused that tree trick.",
            'outcome' => 'wrong',
            'rewind_to' => 'other',
            'choices' => [],
        ],
        'vis' => [
            'message' => "Peel n % 10, add that digit squared, n //= 10. Floyd twin: slow one next, fast two nexts; they meet; true iff the meeting value is 1.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '19 is happy; 2 is not', 'next' => 'cpx'],
                ['label' => '19 is false because 82 is not 1 on the first step, or 2 is true because it is even', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. 19 reaches 1 after 82, 68, 100. 2 falls into the 4-cycle, so it is unhappy.\nStep back to when you scored the samples.",
            'outcome' => 'wrong',
            'rewind_to' => 'vis',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Each next is O(log n). The map collapses to a small set. Space O(k) for vis, or O(1) with Floyd.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Seen set or Floyd; 1 is happy, a repeat is not. Not a range AND, not unbounded recursion', 'next' => 'success'],
                ['label' => 'Stop after a fixed 10 steps; if you have not hit 1 it must be unhappy', 'next' => 'wrong_cap'],
            ],
        ],
        'wrong_cap' => [
            'message' => "You are wrong. A lucky long chain can still reach 1 later. Detect 1 or a repeat; do not guess a step cap unless you prove every unhappy number hits 4.\nStep back to when you capped the loop.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Digit-square next. Seen set (or Floyd) until 1 or a repeat. 19 happy, 2 not. Not range AND, not a tree count, not cap-at-10.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
