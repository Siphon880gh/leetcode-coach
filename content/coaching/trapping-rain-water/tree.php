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
            'message' => "Problem: elevation bars of width 1. How much rain is trapped? [0,1,0,2,1,0,1,3,2,1,2,1] → 6. [4,2,0,3,2,5] → 9. n up to 2e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reuse Container With Most Water: two pointers that maximize (min height)×width', 'next' => 'container'],
                ['label' => 'At each i, water is min(leftMax[i], rightMax[i]) - height[i]', 'next' => 'bound'],
            ],
        ],
        'container' => [
            'message' => "That scores the largest rectangle between two walls. Rain sits in every valley, not one global pair. [4,2,0,3,2,5] traps 9 units in several pockets.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sum every (global max - height[i]); the tallest bar is the waterline', 'next' => 'wrong_global'],
                ['label' => 'A bar i can hold water up to the shorter of the tallest bar on its left and on its right', 'next' => 'bound'],
            ],
        ],
        'wrong_global' => [
            'message' => "You are wrong here.\nWater would spill over the lower neighbor wall. The ceiling is min(left max, right max), not the array maximum.\nStep back to when you chose the waterline.",
            'outcome' => 'wrong',
            'rewind_to' => 'container',
            'choices' => [],
        ],
        'bound' => [
            'message' => "leftMax[i] / rightMax[i] can be filled in O(n) extra, or two pointers can keep running maxes in O(1) extra. Why is it safe to move the side whose current height is smaller?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The min bound on that index is already fixed by its own-side max; the other side is at least as tall as this bar', 'next' => 'example'],
                ['label' => 'You always move the taller side so the pointers meet at the global peak first', 'next' => 'wrong_tall'],
            ],
        ],
        'wrong_tall' => [
            'message' => "You are wrong. You advance the shorter bar. That is the side whose min(leftMax, rightMax) is known without the other pointer moving inward first.\nStep back to when you chose which pointer moves.",
            'outcome' => 'wrong',
            'rewind_to' => 'bound',
            'choices' => [],
        ],
        'example' => [
            'message' => "Prefix arrays: left[i] = max so far from the left (including i), right[i] from the right; add min(l,r)-h. Two pointers: if height[left] < height[right], add leftMax-height[left] (or update leftMax) and left++. Example 1 totals 6.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time; O(n) extra for two arrays, or O(1) extra with two pointers', 'next' => 'success'],
                ['label' => 'O(n²): for each i you must rescan the whole left and right', 'next' => 'wrong_n2'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong. Running maxima (or two pointers) reuse previous work. One or two linear passes are enough.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Water at i is min(leftMax, rightMax) - height[i]. Precompute both max arrays in O(n) extra, or two-pointer the shorter side with running maxes in O(1) extra. Time O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
