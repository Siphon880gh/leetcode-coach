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
            'message' => "Problem: RandomizedCollection is a multiset. insert(val) always stores a new copy and returns true only when val was missing. remove(val) drops one copy if any exist. getRandom picks uniformly from the bag, so insert 1, 1, 2 then 1 with probability 2/3. Average O(1). About 2×10⁵ mixed calls. getRandom is never called on empty.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reuse 380 (one index per value), or sample a random key of the map', 'next' => 'wrong_380'],
                ['label' => 'List of every copy plus a map from value to a set of indices', 'next' => 'ops'],
            ],
        ],
        'wrong_380' => [
            'message' => "You are wrong here. One integer in the map cannot track two copies of 1. Sampling unique keys would give 1 and 2 equal weight after [1, 1, 2].\nStep back to when you used 380 or keyed the random pick.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'ops' => [
            'message' => "Insert: add length to m[val], append, return whether that set just became size 1. Remove: take any index i of val. Copy the last value into slot i. Drop i from val. Drop the old last index from the moved value, and if i was not last, add i to the moved value. Pop the list. Delete the key if val’s set is empty.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip the index-set update when the swapped-in last equals val', 'next' => 'wrong_alias'],
                ['label' => 'When val is also last, the two sets are the same object — drop i first, then the last index', 'next' => 'kind'],
            ],
        ],
        'wrong_alias' => [
            'message' => "You are wrong. If you treat those sets as two objects, you double-drop or leave a stale last index. Same-value swap needs the alias-safe order.\nStep back to when you skipped the same-value index fix.",
            'outcome' => 'wrong',
            'rewind_to' => 'ops',
            'choices' => [],
        ],
        'kind' => [
            'message' => "A second insert is false, but the copy still goes in. getRandom is a random index into the list, not a random key. Do not scan the list to remove.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'List plus index sets. Copies weigh more. Not 380', 'next' => 'success'],
                ['label' => 'Return true on a duplicate insert, or refuse to store the second copy', 'next' => 'wrong_dup'],
            ],
        ],
        'wrong_dup' => [
            'message' => "You are wrong. Duplicate insert is false and still appends. Otherwise [1, 1, 2] cannot give 1 with probability 2/3.\nStep back to when you dropped the extra copy.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. List plus value→index-set. Insert always appends. Remove swaps last into a hole and fixes both index sets. Uniform over the list. Not 380.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
