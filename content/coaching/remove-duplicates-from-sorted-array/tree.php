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
            'message' => "Problem: remove duplicates from a sorted array in place. [1,1,2] → k = 2, nums[:k] = [1,2]. [0,0,1,1,1,2,2,3,3,4] → k = 5. n up to 3·10^4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy into a set (or extra array), then write back', 'next' => 'extra'],
                ['label' => 'Write pointer k; for each x, keep it if k is 0 or x != nums[k-1]', 'next' => 'write'],
            ],
        ],
        'extra' => [
            'message' => "A set uses extra memory and the problem is in-place. Because the array is sorted, duplicates are adjacent — you only compare with the last kept value.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Delete each duplicate with splice/pop so the array shrinks as you go', 'next' => 'wrong_splice'],
                ['label' => 'k starts at 0; if x != nums[k-1] (or k == 0), nums[k] = x, k++. Return k', 'next' => 'write'],
            ],
        ],
        'wrong_splice' => [
            'message' => "You are wrong here.\nEach splice is O(n), so the loop is O(n²). Overwrite from the front instead of deleting from the middle.\nStep back to when you chose how to compact.",
            'outcome' => 'wrong',
            'rewind_to' => 'extra',
            'choices' => [],
        ],
        'write' => [
            'message' => "The judge only reads the first k slots. Junk past k is fine. Why compare x to nums[k-1], not to nums[k]?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'nums[k] is the next write slot, still stale; nums[k-1] is the last unique you already kept', 'next' => 'example'],
                ['label' => 'Compare to nums[k] so you skip when the write slot already holds x', 'next' => 'wrong_slot'],
            ],
        ],
        'wrong_slot' => [
            'message' => "You are wrong. nums[k] has not been written yet (except the first assignment). The unique prefix is nums[0..k).\nStep back to when you chose the compare index.",
            'outcome' => 'wrong',
            'rewind_to' => 'write',
            'choices' => [],
        ],
        'example' => [
            'message' => "[1,1,2]: keep 1 (k=1), skip second 1, keep 2 (k=2). Return 2. Same pattern generalizes to \"keep at most k copies\" by comparing with nums[k-k].\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(1) extra space', 'next' => 'success'],
                ['label' => 'O(n log n) because you must re-sort after overwrites', 'next' => 'wrong_sort'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong. The kept prefix stays sorted because you copy from a sorted scan in order.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One pass, write pointer k. Keep x when it differs from nums[k-1] (or when k is 0). Return k. Time O(n), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
