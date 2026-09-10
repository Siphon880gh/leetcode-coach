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
            'message' => "Problem: move all 0s to the end of nums, keep the relative order of the non-zeros. In place. [0,1,0,3,12] → [1,3,12,0,0].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort the array so zeros drift to the end', 'next' => 'wrong_sort'],
                ['label' => 'Write pointer k packs non-zeros as you scan', 'next' => 'pack'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong here.\nSort would also reorder the non-zeros. The spec keeps their relative order. [0,1,0,3,12] must become [1,3,12,0,0], not a sorted permutation.\nStep back to when you sorted.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'pack' => [
            'message' => "k = 0. For each i, if nums[i] is not 0, swap nums[i] with nums[k] and bump k. Prefix [0 .. k) is the original non-zeros; the rest are zeros. Swap when i equals k is a no-op.\nHow do you ship it?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Collect non-zeros into a new list, then fill zeros', 'next' => 'wrong_copy'],
                ['label' => 'In place: O(n) time, O(1) extra. Optional: copy only when i != k, then fill the tail with zeros', 'next' => 'cpx'],
            ],
        ],
        'wrong_copy' => [
            'message' => "You are wrong. The note forbids a copy of the array. Pack into the same nums with k.\nStep back to when you allocated a second list.",
            'outcome' => 'wrong',
            'rewind_to' => 'pack',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(1) extra. Same write-pointer idea as Remove Element (27), but you keep the zeros by swapping them right instead of shrinking the length.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'k packs non-zeros in order. Not sort, not a second array, not Sort Colors three-way unless you want extra work', 'next' => 'success'],
                ['label' => 'Sort Colors three-way partition; zeros, then non-zeros, then ignore 2s', 'next' => 'wrong_75'],
            ],
        ],
        'wrong_75' => [
            'message' => "You are wrong. Sort Colors partitions three values. Here values are anything; you only care zero vs not, and you must keep non-zero order, which a 0/1/2 Dutch flag does not guarantee among the non-zeros.\nStep back to when you imported Sort Colors.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Write pointer k. Swap each non-zero into the next slot. In place. Order of non-zeros stays. [0,1,0,3,12] → [1,3,12,0,0].\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
