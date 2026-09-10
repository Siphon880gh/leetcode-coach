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
            'message' => "Problem: hit(timestamp) records a hit. getHits(timestamp) counts hits in the past 300 seconds, i.e. timestamps ≥ t−299. Calls arrive in order; several hits may share t. Hits at 1, 2, 3 then getHits(4) is 3; hit 300 then getHits(300) is 4 and getHits(301) is 3. At most 300 calls.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep one running total with no expiry, or reuse Logger Rate Limiter (359) per message', 'next' => 'wrong_total'],
                ['label' => 'Append timestamps. Binary-search the first kept time, or drop a deque front older than t−300', 'next' => 'window'],
            ],
        ],
        'wrong_total' => [
            'message' => "You are wrong here. A forever counter never ages out the hit at 1 when t is 301. 359 is a per-message 10-second cooldown, not a 300-second count.\nStep back to when you skipped the sliding window.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'window' => [
            'message' => "Doocs: ts.append(t). getHits is len(ts) minus the first index whose value is at least t−299 (bisect_left of t−300+1). Deque twin: pop left while front ≤ t−300, then return remaining size. Hit at 1 is still in getHits(300) and gone at 301.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Drop the hit at 1 when t is 300, or keep it when t is 301', 'next' => 'wrong_off'],
                ['label' => 'Window is [t−299, t]. Keep time 1 at t=300; drop it at t=301', 'next' => 'kind'],
            ],
        ],
        'wrong_off' => [
            'message' => "You are wrong. Past 300 seconds from 300 still includes timestamp 1. From 301 it does not.\nStep back to when you off-by-oned the window.",
            'outcome' => 'wrong',
            'rewind_to' => 'window',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Follow-up bursts in one second: store (time, count) on the deque, or 300 buckets keyed by t mod 300. You do not need to rescan all history if time is sorted or queued.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sorted list plus lower bound, or deque eviction. Not 359. Window [t−299, t]', 'next' => 'success'],
                ['label' => 'On every getHits, loop from the first hit ever, even after you have a sorted ts', 'next' => 'wrong_scan'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong. The list is already sorted by time. Lower bound (or deque pops) already drops the stale prefix.\nStep back to when you scanned from the beginning each query.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Count timestamps ≥ t−299. Binary search a sorted list or drop a deque front. Hits 1,2,3 then 300: getHits(300) is 4 and getHits(301) is 3. Not Logger Rate Limiter.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
