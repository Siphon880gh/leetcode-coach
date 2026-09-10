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
            'message' => "Problem: maxNumbers slots 0..n−1 (n up to 1e4). get assigns any unused number, or −1 if none remain. check(number) is true iff that slot is still free. release(number) returns a slot to the pool. Example n=3: two gets, check(2) can still be true; a third get takes 2; check(2) is false; release(2) then check(2) is true. About 2×10⁴ mixed calls.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Scan 0..n−1 on every get, or treat this as LRU (146) / GetRandom (380)', 'next' => 'wrong_scan'],
                ['label' => 'Keep a hash set (or queue) of unused ids; get pops one', 'next' => 'ops'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong here. Scanning 0..n on every get is too slow at n = 1e4 with 2e4 calls. 146 evicts by recency. 380 picks a uniform used member. This is a pool of integer slots.\nStep back to when you scanned or used 146 / 380.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'ops' => [
            'message' => "Fill available with range(maxNumbers). get: if empty return −1, else pop any element. check: number in available. release: add number back. A boolean array plus a free-list queue is the same idea: enqueue on release only if the slot was taken.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Crash or skip if release is called on an already-free number', 'next' => 'wrong_rel'],
                ['label' => 'release of an already-free slot is a no-op; get may return any remaining id', 'next' => 'kind'],
            ],
        ],
        'wrong_rel' => [
            'message' => "You are wrong. Adding a slot that is already free must stay a no-op, not throw. get does not have to return the smallest leftover.\nStep back to when you required a crash or a sorted pop.",
            'outcome' => 'wrong',
            'rewind_to' => 'ops',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Do not hand out a number that is still in available. After get, that id must leave the set so check is false until release.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Set or free-list, O(1) ops. Not scan. Not 146. Not 380', 'next' => 'success'],
                ['label' => 'Leave the id in available after get so check stays true', 'next' => 'wrong_keep'],
            ],
        ],
        'wrong_keep' => [
            'message' => "You are wrong. get must remove the id. Otherwise check would still say free and a later get could hand it out twice.\nStep back to when you left the assigned id in the pool.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Set of free slots; get pops; check is membership; release adds (no-op if already free). n=3 example matches the writeup. Not 146. Not 380.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
