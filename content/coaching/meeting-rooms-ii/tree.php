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
            'message' => "Problem: minimum conference rooms so every meeting gets one. [[0,30],[5,10],[15,20]] → 2. [[7,10],[2,4]] → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Meeting Rooms (252): return whether one person can attend all; or Merge Intervals and output 1', 'next' => 'bool'],
                ['label' => 'Peak concurrent: +1 at each start, −1 at each end; running sum’s max is the answer', 'next' => 'sweep'],
            ],
        ],
        'bool' => [
            'message' => "252 is a boolean (any overlap?). Merge unions ranges; that does not count rooms. Here overlap is allowed — you count how many overlap at once.\nHow do you encode start and end?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Difference array or map: d[start] += 1, d[end] -= 1; prefix-sum and take the max', 'next' => 'sweep'],
                ['label' => 'A meeting ending at t and another starting at t need two rooms', 'next' => 'wrong_touch'],
            ],
        ],
        'wrong_touch' => [
            'message' => "You are wrong here.\nAn end at t does not overlap a start at t. Put −1 on d[end] so they cancel in the same bucket and can share a room.\nStep back to when you treated touching as two rooms.",
            'outcome' => 'wrong',
            'rewind_to' => 'bool',
            'choices' => [],
        ],
        'sweep' => [
            'message' => "Heap twin: sort by start; min-heap of end times. If next start ≥ earliest end, pop (reuse); else push. Answer is max heap size.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[[0,30],[5,10],[15,20]] peaks at 2 (0–10 overlap, then 15–20 reuses after 10)', 'next' => 'cpx'],
                ['label' => 'Return true/false like 252 because two meetings overlap', 'next' => 'wrong_252'],
            ],
        ],
        'wrong_252' => [
            'message' => "You are wrong. Overlap here means another room, not a false. The return type is an integer count.\nStep back to when you reused 252’s boolean.",
            'outcome' => 'wrong',
            'rewind_to' => 'sweep',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n log n) map/heap, or O(n + m) dense difference array of size m = max end. Not a boolean, not merge-to-one, not two rooms for a shared instant.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sweep or heap of ends; peak concurrent is min rooms; touching reuses', 'next' => 'success'],
                ['label' => 'Integer to English Words: convert the room count to words', 'next' => 'wrong_words'],
            ],
        ],
        'wrong_words' => [
            'message' => "You are wrong. This problem returns an integer, not English words.\nStep back to when you changed the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. +1 at start, −1 at end. Prefix-sum peak (or a min-heap of ends). An end at t frees a room for a start at t. Do not return a boolean, merge into one interval, or double-count a shared instant.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
