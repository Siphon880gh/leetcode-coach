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
            'message' => "Problem: remove every val from nums in place. Return k; the first k slots must be the keepers (order may change). [3,2,2,3], val = 3 → k = 2, nums[:k] = [2,2]. [0,1,2,2,3,0,4,2], val = 2 → k = 5. n ≤ 100.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Filter into a new array, then copy back', 'next' => 'extra'],
                ['label' => 'Write pointer k; for each x, keep it if x != val', 'next' => 'write'],
            ],
        ],
        'extra' => [
            'message' => "A new array uses extra memory. The problem is in-place: overwrite keepers onto the front and return how many you wrote.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Delete each val with splice/pop so the array shrinks as you go', 'next' => 'wrong_splice'],
                ['label' => 'k starts at 0; if x != val, nums[k] = x, k++. Return k', 'next' => 'write'],
            ],
        ],
        'wrong_splice' => [
            'message' => "You are wrong here.\nEach splice is O(n), so the loop is O(n²). Overwrite keepers from the front instead of deleting from the middle.\nStep back to when you chose how to compact.",
            'outcome' => 'wrong',
            'rewind_to' => 'extra',
            'choices' => [],
        ],
        'write' => [
            'message' => "The judge only reads the first k slots (it even sorts them). Junk past k is fine. Unlike “remove duplicates,” you keep every x that is not val — repeats of other values stay.\nWhat do you compare x against?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep x whenever x != val; do not skip just because x equals the last kept value', 'next' => 'example'],
                ['label' => 'Skip x when x == nums[k-1], same as compacting uniques', 'next' => 'wrong_unique'],
            ],
        ],
        'wrong_unique' => [
            'message' => "You are wrong. This is not LeetCode 26. Duplicate keepers are allowed; only val is dropped. Example [2,2], val = 3 must still return k = 2.\nStep back to when you chose the keep test.",
            'outcome' => 'wrong',
            'rewind_to' => 'write',
            'choices' => [],
        ],
        'example' => [
            'message' => "[3,2,2,3], val = 3: skip 3, keep 2 (k=1), keep 2 (k=2), skip 3. Return 2. Swapping with the tail also works because order may change, but one write pointer is enough.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(1) extra space', 'next' => 'success'],
                ['label' => 'O(n log n) because you must sort the prefix yourself', 'next' => 'wrong_sort'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong. The custom judge sorts the first k slots for you. You only need the keepers packed in front, in any order.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One pass, write pointer k. Keep x when x != val. Return k. Time O(n), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
