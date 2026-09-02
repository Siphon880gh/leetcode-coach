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
            'message' => "Problem: intervals is already sorted and non-overlapping. Insert newInterval and merge if it overlaps (shared endpoint counts). [[1,3],[6,9]] + [2,5] → [[1,5],[6,9]]. n up to 1e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Binary-search the start, splice newInterval in, and leave the rest unchanged', 'next' => 'splice'],
                ['label' => 'Append newInterval, sort by start, then the same merge pass as Merge Intervals', 'next' => 'merge'],
            ],
        ],
        'splice' => [
            'message' => "A sorted insert by start can still overlap neighbors. [[1,3],[6,9]] plus [2,5] is not [[1,3],[2,5],[6,9]].\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Run Merge Intervals on the original list and drop newInterval', 'next' => 'wrong_drop'],
                ['label' => 'Put newInterval into the pile, sort, then merge: flush when last end < next start, else extend last end', 'next' => 'merge'],
            ],
        ],
        'wrong_drop' => [
            'message' => "You are wrong here.\nMerge Intervals (56) has no extra range to add. This problem is defined by that one extra interval.\nStep back to when you ignored newInterval.",
            'outcome' => 'wrong',
            'rewind_to' => 'splice',
            'choices' => [],
        ],
        'merge' => [
            'message' => "Why sort again if intervals was already sorted?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'newInterval can sit anywhere; after append the list is unsorted until you sort', 'next' => 'example'],
                ['label' => 'Sorting is waste; append at the end and merge only the last two ranges', 'next' => 'wrong_tail'],
            ],
        ],
        'wrong_tail' => [
            'message' => "You are wrong. [4,8] can overlap several middle ranges, not only the last. After append you must sort (or scan linearly for the overlap window).\nStep back to when you merged only the tail.",
            'outcome' => 'wrong',
            'rewind_to' => 'merge',
            'choices' => [],
        ],
        'example' => [
            'message' => "[[1,2],[3,5],[6,7],[8,10],[12,16]] + [4,8] → [[1,2],[3,10],[12,16]]. Empty intervals → just [newInterval]. Touching endpoints merge.\nWhat is the writeup complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n log n) time from the sort after append; O(n) extra for the new list', 'next' => 'success'],
                ['label' => 'O(n²) because each insert must scan every pair again', 'next' => 'wrong_n2'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong. One sort plus one left-to-right merge is enough. Pairwise rescans are Merge Intervals done the slow way.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Append newInterval, sort, then merge like 56: if last end < s, push; else last end = max(last end, e). Sorted non-overlapping input plus one range — not 56 on the original list alone, and not a splice that leaves overlaps.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
