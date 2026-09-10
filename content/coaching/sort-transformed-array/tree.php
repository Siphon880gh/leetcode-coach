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
            'message' => "Problem: nums is already sorted. Return f(x) = a × x² + b × x + c for every x, already in sorted order. [-4, -2, 2, 4] with a = 1, b = 3, c = 5 → [3, 9, 15, 33]. Same nums with a = -1 → [-23, -5, 1, 7]. n is at most 200. Follow-up is linear time.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Compute f at every index, then sort those n values', 'next' => 'wrong_sort'],
                ['label' => 'Two pointers on the ends: f is a parabola, so extrema sit at the current ends', 'next' => 'ends'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong here. Mapping then sorting is n log n. The follow-up asks for linear time using that nums is already sorted.\nStep back to when you sorted the transformed values.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'ends' => [
            'message' => "a > 0 opens upward: the vertex is a minimum, so the two ends hold the largest remaining f values. Fill the answer from the back with the larger of f(left) and f(right), then move that pointer inward. a ≤ 0 (including a line when a = 0): fill from the front with the smaller end.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always fill from the back, or treat a = 0 as a separate sort', 'next' => 'wrong_sign'],
                ['label' => 'a > 0 fill back with the larger end; a ≤ 0 fill front with the smaller end', 'next' => 'kind'],
            ],
        ],
        'wrong_sign' => [
            'message' => "You are wrong. Opening downward (or a line) puts the next smallest at an end, so you write from the front. a = 0 is the a ≤ 0 branch, not a new sort.\nStep back to when you ignored the sign of a.",
            'outcome' => 'wrong',
            'rewind_to' => 'ends',
            'choices' => [],
        ],
        'kind' => [
            'message' => "You do not need to locate the vertex and merge two halves. Compare f at the two pointers until the answer is full. Ties may take either end.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Parabola two-pointers. a > 0 from the back; a ≤ 0 from the front. Not map-then-sort', 'next' => 'success'],
                ['label' => 'Binary-search the vertex, then merge the two monotonic halves as the only linear method', 'next' => 'wrong_vertex'],
            ],
        ],
        'wrong_vertex' => [
            'message' => "You are wrong. Finding the vertex works but adds casework. End-vs-end pointers already walk the same unimodal shape in linear time.\nStep back to when you required a vertex search.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sorted domain plus a parabola: a > 0 fills from the back with the larger end; a ≤ 0 fills from the front with the smaller end. [-4, -2, 2, 4], a = 1 → [3, 9, 15, 33]. Not map then sort.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
