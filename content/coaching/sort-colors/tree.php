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
            'message' => "Problem: sort nums of only 0, 1, 2 in place, red-white-blue order, no library sort. [2,0,2,1,1,0] → [0,0,1,1,2,2]. Follow-up: one pass, O(1) extra.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Call a language sort, or count 0/1/2 then rewrite in a second pass', 'next' => 'count'],
                ['label' => 'Three pointers: i grows the 0-block, j shrinks the 2-block, k walks the unknown middle', 'next' => 'three'],
            ],
        ],
        'count' => [
            'message' => "Library sort is forbidden. A count-then-write is two passes. The writeup is one pass with three pointers.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Bubble adjacent swaps until the array is sorted', 'next' => 'wrong_bubble'],
                ['label' => 'Maintain [0..i] as 0s, [j..n-1] as 2s, and scan k while k < j', 'next' => 'three'],
            ],
        ],
        'wrong_bubble' => [
            'message' => "You are wrong here.\nBubble is extra comparisons; the Dutch-flag partition is O(n) with a few swaps.\nStep back to when you chose bubble sort.",
            'outcome' => 'wrong',
            'rewind_to' => 'count',
            'choices' => [],
        ],
        'three' => [
            'message' => "Start i=-1, j=n, k=0. On 0: swap with i+1, then i++ and k++. On 2: swap with j-1, then j--. Why not k++ after a 2-swap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The value swapped in from the right is unexamined; it may be 0 or 2', 'next' => 'void'],
                ['label' => 'Always advance k; the right side is already known to be 2s', 'next' => 'wrong_k'],
            ],
        ],
        'wrong_k' => [
            'message' => "You are wrong. j marks the first 2, not cells already classified. After swap, nums[k] is a new unknown. Skip k++ only on the 2 branch.\nStep back to when you always advanced k.",
            'outcome' => 'wrong',
            'rewind_to' => 'three',
            'choices' => [],
        ],
        'void' => [
            'message' => "On 1, only k++. Time O(n), extra O(1). The method returns void.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Nothing — mutate nums so 0s, then 1s, then 2s sit in place', 'next' => 'success'],
                ['label' => 'A new sorted copy, like Merge Sorted Array’s extra buffer', 'next' => 'wrong_copy'],
            ],
        ],
        'wrong_copy' => [
            'message' => "You are wrong. This signature is in-place void. Merge Sorted Array writes into a provided nums1; it does not sort three colors.\nStep back to when you allocated a copy.",
            'outcome' => 'wrong',
            'rewind_to' => 'void',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Dutch flag: i=-1, j=n, k=0. Swap 0s left and advance k; swap 2s right and leave k; skip 1s with k++. One pass, O(1) extra. Not library sort, not a count rewrite, not bubble.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
