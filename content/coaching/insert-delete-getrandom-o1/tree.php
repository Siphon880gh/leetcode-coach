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
            'message' => "Problem: RandomizedSet. insert(val) is true iff it was new. remove(val) is true iff it was present. getRandom is a uniform member (the set is never empty on that call). Average O(1) per op. Example: insert 1, remove 2 (false), insert 2, getRandom is 1 or 2, remove 1, insert 2 (false), getRandom is 2. About 2×10⁵ mixed calls.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hash set only, or an array you scan on every remove', 'next' => 'wrong_set'],
                ['label' => 'List of values plus a map from value to its index in that list', 'next' => 'ops'],
            ],
        ],
        'wrong_set' => [
            'message' => "You are wrong here. A set has no O(1) uniform pick. An array alone makes remove a scan.\nStep back to when you used a set-only or a scan-remove.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'ops' => [
            'message' => "Insert: if val is already in the map, false; else map[val] = length, append, true. Remove: if missing, false. Let i be the index. Copy the last value into slot i, set that last value’s index to i, pop the list, delete val from the map. If val was already last, the swap is a no-op and still works. getRandom is a random index into the list.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Erase a middle index without the swap-with-last, or forget to update the moved last value', 'next' => 'wrong_swap'],
                ['label' => 'Swap-with-last, then fix the moved value’s index; pop val from the map last', 'next' => 'kind'],
            ],
        ],
        'wrong_swap' => [
            'message' => "You are wrong. Leaving a hole or dropping the last value’s map entry after it moved into i breaks later remove and getRandom.\nStep back to when you skipped the swap or the index fix.",
            'outcome' => 'wrong',
            'rewind_to' => 'ops',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Duplicate insert is false. Duplicates allowed is problem 381 (a bag of indices per value). Phone Directory (379) is a pool of free integers, not a random used member.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Array plus index map. Not 379. Not 381', 'next' => 'success'],
                ['label' => 'Treat a second insert as true, or walk the map in getRandom', 'next' => 'wrong_dup'],
            ],
        ],
        'wrong_dup' => [
            'message' => "You are wrong. A second insert of the same val is false. getRandom must pick from the list, not walk the map.\nStep back to when you accepted a duplicate or scanned the map.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. List plus value→index. Insert appends. Remove swaps with last, fixes the index, pops. Uniform pick from the list. Not 379. Not 381.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
