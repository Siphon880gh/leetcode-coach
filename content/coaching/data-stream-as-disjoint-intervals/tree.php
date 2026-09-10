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
            'message' => "Problem: addNum then getIntervals — summarize seen values as sorted disjoint closed intervals. 1, 3, 7, 2, 6 → finally [[1, 3], [6, 7]]. Values up to 1e4; about 3×10^4 mixed calls.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep every number, then run Merge Intervals (56) on a full list each getIntervals', 'next' => 'wrong_56'],
                ['label' => 'Ordered map of runs. Floor and ceiling around val; merge, extend, or insert [val, val]', 'next' => 'map'],
            ],
        ],
        'wrong_56' => [
            'message' => "You are wrong here. The follow-up is few disjoint runs versus a long stream. Rebuilding 56 each query is extra work.\nStep back to when you merged the whole history every time.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'map' => [
            'message' => "Floor = greatest start ≤ val. Ceiling = least start ≥ val. If val is already in floor’s range, ignore. If floor ends at val−1 and ceiling starts at val+1, stitch them. Else extend one neighbor or insert a singleton.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A duplicate inside a range splits it, or 2 between 1 and 3 leaves [[1,1],[2,2],[3,3]]', 'next' => 'wrong_dup'],
                ['label' => 'Duplicates are no-ops. Adding 2 after 1 and 3 yields [[1, 3]]', 'next' => 'cpx'],
            ],
        ],
        'wrong_dup' => [
            'message' => "You are wrong. Values already covered stay one interval. 1 then 3 then 2 must become [1, 3], not three singletons.\nStep back to when you split on a duplicate or skipped the stitch.",
            'outcome' => 'wrong',
            'rewind_to' => 'map',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "getIntervals dumps the map values in start order. Time O(log k) per add, O(k) to dump. Space O(k) runs.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'TreeMap of disjoint runs. Floor/ceiling merge. Not a full 56 rebuild', 'next' => 'success'],
                ['label' => 'Leave overlapping ranges and sort them only in getIntervals', 'next' => 'wrong_ov'],
            ],
        ],
        'wrong_ov' => [
            'message' => "You are wrong. The stored intervals must stay disjoint after every addNum, not only after a later sort.\nStep back to when you allowed overlap.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Ordered map of runs. Floor and ceiling: ignore inside, stitch both neighbors, extend one side, or insert. 1 then 3 then 2 → [[1, 3]]. Not Merge Intervals each query.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
