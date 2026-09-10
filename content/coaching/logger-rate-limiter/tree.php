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
            'message' => "Problem: shouldPrintMessage(timestamp, message) on a chronological stream. A unique message prints at most once every 10 seconds: if it printed at t, the next identical print is allowed at t+10. Several messages may share a timestamp. foo at 1 is true, bar at 2 is true, foo at 3 and 10 are false, foo at 11 is true. At most 1e4 calls.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep one last-print clock for the whole logger; every message shares that cooldown', 'next' => 'wrong_global'],
                ['label' => 'Map each message to the next allowed timestamp (missing key means 0)', 'next' => 'map'],
            ],
        ],
        'wrong_global' => [
            'message' => "You are wrong here. foo and bar have independent 10-second windows. One clock would block bar at 2 after foo at 1.\nStep back to when you used a global cooldown.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'map' => [
            'message' => "On each call, let next = ts.get(message, 0). If timestamp is less than next, return false. Else set ts[message] = timestamp + 10 and return true.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat t+10 as still blocked, so foo at 1 next prints only at 12', 'next' => 'wrong_strict'],
                ['label' => 'Print when timestamp is at least next, then store timestamp + 10. Unseen starts at 0', 'next' => 'kind'],
            ],
        ],
        'wrong_strict' => [
            'message' => "You are wrong. A print at t allows the identical message again at t+10, not t+11. foo at 1 then 11 must be true.\nStep back to when you required a strict gap past t+10.",
            'outcome' => 'wrong',
            'rewind_to' => 'map',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Timestamps already arrive in non-decreasing order. A queue of the last 10 seconds can drop stale keys, but it is not required for correctness. Do not store last-print time and then test timestamp - last < 10 with an off-by-one that blocks t+10.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Per-message next-allowed map. Print if t >= next, then t+10. Queue is optional eviction only', 'next' => 'success'],
                ['label' => 'A sliding 10-second queue is the only correct structure; drop the hash map', 'next' => 'wrong_queue'],
            ],
        ],
        'wrong_queue' => [
            'message' => "You are wrong. Membership plus next-allowed time is enough. A queue only helps reclaim memory; it does not replace the map.\nStep back to when you required a queue as the only design.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Map message to next allowed t (unseen 0). Print if timestamp is at least that, then store timestamp + 10. foo at 1 then 11 is true; 10 is still blocked. Not one global cooldown.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
