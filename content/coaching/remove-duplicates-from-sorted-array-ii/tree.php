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
            'message' => "Problem: sorted nums, in-place, each value at most twice. Return k for the kept prefix. [1,1,1,2,2,3] → k=5, [1,1,2,2,3]. O(1) extra. n up to 3e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep x when it differs from nums[k-1], like Remove Duplicates from Sorted Array (at most one)', 'next' => 'one'],
                ['label' => 'Write pointer k; keep x if k < 2 or x != nums[k-2]', 'next' => 'two'],
            ],
        ],
        'one' => [
            'message' => "Problem 26 compares nums[k-1] and keeps a single copy. Here two 1s must stay; only the third 1 is dropped.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy into a new array, then write back', 'next' => 'wrong_copy'],
                ['label' => 'Compare with nums[k-2]: if x equals the value two slots back in the kept prefix, skip it', 'next' => 'two'],
            ],
        ],
        'wrong_copy' => [
            'message' => "You are wrong here.\nThe problem forbids extra array space. Overwrite from the front with O(1) extra.\nStep back to when you allocated a copy.",
            'outcome' => 'wrong',
            'rewind_to' => 'one',
            'choices' => [],
        ],
        'two' => [
            'message' => "k starts at 0. First two writes always happen (k < 2). After that, nums[k-2] is the second-to-last kept value. Why not compare to nums[k]?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'nums[k] is the next write slot, still stale; the kept prefix is nums[0..k)', 'next' => 'ret'],
                ['label' => 'Write keepers that are not val, like Remove Element', 'next' => 'wrong_val'],
            ],
        ],
        'wrong_val' => [
            'message' => "You are wrong. Remove Element drops every val. This problem keeps up to two of each sorted run.\nStep back to when you reused Remove Element.",
            'outcome' => 'wrong',
            'rewind_to' => 'two',
            'choices' => [],
        ],
        'ret' => [
            'message' => "[1,1,1,2,2,3]: keep 1, keep 1, skip third 1 (equals nums[k-2]), keep 2s and 3. Return 5. Time O(n), extra O(1).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'k — the judge reads nums[0..k); junk past k is fine', 'next' => 'success'],
                ['label' => 'The whole mutated array; ignore k, like Sort Colors void', 'next' => 'wrong_void'],
            ],
        ],
        'wrong_void' => [
            'message' => "You are wrong. This signature returns k. Sort Colors is a different in-place void partition.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One pass, k=0. Keep x when k<2 or x != nums[k-2]. At most two copies, not problem 26’s one copy, not Remove Element, not Sort Colors. Time O(n), extra O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
