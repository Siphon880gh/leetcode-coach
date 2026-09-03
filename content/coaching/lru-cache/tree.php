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
            'message' => "Problem: cache of capacity; get(key) is the value or -1; put updates or inserts and evicts the least recently used when over capacity. get and put O(1). Sample capacity 2: get 1 after putting 1 and 2 is 1; put 3 evicts 2.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A plain dict (no recency), a FIFO queue, an O(n) scan list, Copy List’s random map, or tree preorder', 'next' => 'plain'],
                ['label' => 'Hash key→node, dummy head/tail DLL: move accessed nodes to the head; evict tail.prev', 'next' => 'dll'],
            ],
        ],
        'plain' => [
            'message' => "A dict cannot tell which key is oldest. FIFO ignores get as a use. A list scan is not O(1). Copy List and preorder are different problems.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Evict head.next (most recent), or use Cycle I’s Floyd pointers', 'next' => 'wrong_other'],
                ['label' => 'O(1) unlink from the middle of a DLL, plus a map to find the node', 'next' => 'dll'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nHead is most recent in this layout, so evicting it drops the hot key. Floyd finds cycles, not LRU.\nStep back to when you evicted the wrong end.",
            'outcome' => 'wrong',
            'rewind_to' => 'plain',
            'choices' => [],
        ],
        'dll' => [
            'message' => "get: miss → -1; hit → remove_node, add_to_head, return val. put: if present, update val and move to head; else insert at head, and if size > capacity pop tail.prev from the map and unlink it.\nWhy store key on the node, not only val?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Eviction starts from the list node; you need the key to delete the map entry', 'next' => 'ret'],
                ['label' => 'The map already has keys, so the node only needs val', 'next' => 'wrong_key'],
            ],
        ],
        'wrong_key' => [
            'message' => "You are wrong. From tail.prev you do not know the key unless the node stores it. Then cache.pop cannot run in O(1).\nStep back to when you omitted the key on the node.",
            'outcome' => 'wrong',
            'rewind_to' => 'dll',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Time O(1) per op, space O(capacity). Dummy sentinels avoid empty-list edge cases. After the sample, get 3 is 3 and get 4 is 4; 1 and 2 are gone.\nWhat does get return on a miss?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '-1, and a hit both returns the value and marks the key most recent', 'next' => 'success'],
                ['label' => '0, or None, without moving the node', 'next' => 'wrong_miss'],
            ],
        ],
        'wrong_miss' => [
            'message' => "You are wrong. The spec says -1 on a miss. A hit must move the node to the head or it is not LRU.\nStep back to when you skipped the move.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Map + dummy DLL. Move to head on get/put. Evict tail.prev. O(1). Not FIFO, not a scan, not Copy List, not Floyd, not preorder. Store key on the node for eviction.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
