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
            'message' => "Problem: merge overlapping [start, end] ranges. [[1,3],[2,6],[8,10],[15,18]] → [[1,6],[8,10],[15,18]]. Touching counts: [1,4] and [4,5] → [1,5]. Unsorted input: [[4,7],[1,4]] → [[1,7]]. n up to 1e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Walk the list in given order and merge each pair with its neighbor', 'next' => 'nosort'],
                ['label' => 'Sort by left endpoint, then one pass: if ed < s flush, else ed = max(ed, e)', 'next' => 'merge'],
            ],
        ],
        'nosort' => [
            'message' => "Neighbors in input order are not time-neighbors. [[4,7],[1,4]] overlap but sit as two separate items until you sort.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Insert one extra interval into an already merged list (Insert Interval)', 'next' => 'wrong_insert'],
                ['label' => 'Sort by start, hold [st, ed], then compare each next [s, e] against ed', 'next' => 'merge'],
            ],
        ],
        'wrong_insert' => [
            'message' => "You are wrong here.\nInsert Interval assumes a sorted, already merged list plus one new range. This problem must merge an arbitrary pile.\nStep back to when you reused insert.",
            'outcome' => 'wrong',
            'rewind_to' => 'nosort',
            'choices' => [],
        ],
        'merge' => [
            'message' => "The writeup flushes when ed < s, not when ed <= s. Why treat equal endpoints as overlap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The statement counts a shared endpoint as overlapping, so [1,4] and [4,5] become [1,5]', 'next' => 'example'],
                ['label' => 'Closed intervals still should stay split at a shared point; only interiors merge', 'next' => 'wrong_touch'],
            ],
        ],
        'wrong_touch' => [
            'message' => "You are wrong. Example 2 merges [1,4] and [4,5] into [1,5]. A shared endpoint is overlap here.\nStep back to when you split touching ranges.",
            'outcome' => 'wrong',
            'rewind_to' => 'merge',
            'choices' => [],
        ],
        'example' => [
            'message' => "After the loop, append the last [st, ed]. Nested intervals: ed = max(ed, e) so a short next range does not shrink the cover.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n log n) from the sort; O(log n) extra in the writeup (sort stack)', 'next' => 'success'],
                ['label' => 'O(n) without sorting, because you can sweep every integer from 0 to 1e4', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. The taught solution sorts the n intervals. A value-axis sweep is a different trick and not the writeup.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort by start. Hold [st, ed]. If ed < s, emit and restart; else ed = max(ed, e). Touching endpoints merge. Time O(n log n). Not input-order neighbor merges, and not Insert Interval.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
