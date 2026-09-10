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
            'message' => "Problem: addNum then findMedian on a growing stream. Odd count: middle. Even: mean of the two middles. Add 1, add 2 → 1.5. Add 3 → 2.0. Up to 5×10⁴ calls.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep a list and sort (or scan) on every findMedian', 'next' => 'wrong_sort'],
                ['label' => 'Max-heap for the smaller half, min-heap for the larger half', 'next' => 'heaps'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong here.\nA full sort each query is too slow at 5×10⁴. Two heaps keep the middle at the tops.\nStep back to when you resorted the history.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'heaps' => [
            'message' => "maxQ = smaller half (top is the largest small). minQ = larger half (top is the smallest large). addNum: push onto maxQ, pop that max into minQ. If len(minQ) − len(maxQ) > 1, pop minQ back onto maxQ.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip rebalance; let minQ grow two ahead', 'next' => 'wrong_bal'],
                ['label' => 'Equal sizes: average of both tops. Else minQ top. O(log n) add', 'next' => 'cpx'],
            ],
        ],
        'wrong_bal' => [
            'message' => "You are wrong. If minQ is two larger, neither top is the median. Rebalance when the gap is more than one.\nStep back to when you skipped rebalance.",
            'outcome' => 'wrong',
            'rewind_to' => 'heaps',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Sliding Window Median is a window, not the whole stream. Python max-heap is negated values.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Two heaps, rebalance. Not a full sort, not a window median', 'next' => 'success'],
                ['label' => 'Dump everything into one min-heap and the median is always the top', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. A single min-heap top is the smallest, not the median.\nStep back to when you used one heap.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Smaller half max-heap, larger half min-heap. Push, spill to minQ, rebalance. Odd: minQ top. Even: average. O(log n) add, O(1) median.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
