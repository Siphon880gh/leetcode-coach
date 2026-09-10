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
            'message' => "Problem: can one person attend all meetings? intervals[i] = [start, end]. Meetings that meet at the same instant do not overlap. [[0,30],[5,10],[15,20]] is false. [[7,10],[2,4]] is true. Empty is true.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Merge Intervals (56) into unions; or Meeting Rooms II: count how many rooms you need', 'next' => 'merge'],
                ['label' => 'Sort by start, then check only consecutive pairs: prev.end > next.start means overlap', 'next' => 'sort'],
            ],
        ],
        'merge' => [
            'message' => "56 unions overlapping ranges. 253 counts max concurrent rooms. Here you only need yes/no: any overlap at all?\nWhat is the check after sorting by start?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'For each neighbor pair, if previous end is greater than next start, return false; else true at the end', 'next' => 'sort'],
                ['label' => 'If two meetings share an endpoint (end = t, next start = t), treat that as overlap', 'next' => 'wrong_touch'],
            ],
        ],
        'wrong_touch' => [
            'message' => "You are wrong here.\nThe problem says meetings that meet at time t do not overlap. prev.end ≤ next.start is allowed.\nStep back to when you treated a shared instant as busy.",
            'outcome' => 'wrong',
            'rewind_to' => 'merge',
            'choices' => [],
        ],
        'sort' => [
            'message' => "Unsorted [[7,10],[2,4]] becomes [[2,4],[7,10]]; 4 ≤ 7 so true. After a start-sort, a clash with a non-neighbor would already clash with someone in between.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[[0,30],[5,10],[15,20]] → 30 > 5, overlap, false', 'next' => 'cpx'],
                ['label' => 'Skip the sort and compare each interval to every other in the given order', 'next' => 'wrong_n2'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong. Pairwise without sorting still works if you check all pairs, but it is slower and easy to miss. The intended walk is sort then neighbors.\nStep back to when you skipped the sort.",
            'outcome' => 'wrong',
            'rewind_to' => 'sort',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n log n) time, sort-stack space. Empty list is true. Not 56 merge, not 253 room count, not treating a shared endpoint as overlap.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort by start; consecutive prev.end ≤ next.start; touching is fine', 'next' => 'success'],
                ['label' => 'Sweep a min-heap of end times like Meeting Rooms II and return the heap size', 'next' => 'wrong_253'],
            ],
        ],
        'wrong_253' => [
            'message' => "You are wrong. Heap size is the number of rooms (253). This problem is a boolean: any overlap?\nStep back to when you counted concurrent meetings.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort by start. Walk neighbors: if prev.end > next.start, false. Touching endpoints are allowed. Empty is true. Do not merge intervals, count rooms, or treat a shared instant as busy.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
