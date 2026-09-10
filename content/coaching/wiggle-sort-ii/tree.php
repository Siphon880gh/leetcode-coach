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
            'message' => "Problem: reorder nums so nums[0] < nums[1] > nums[2] < … (strict). A valid answer is guaranteed. [1,5,1,1,6,4] → [1,6,1,5,1,4]. Length up to 5e4; values 0..5000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Wiggle Sort 280 adjacent swap (≤ / ≥), or sort then interleave forward', 'next' => 'wrong_280'],
                ['label' => 'Sort a copy; even k from mid of small half downward; odd k from the end', 'next' => 'fill'],
            ],
        ],
        'wrong_280' => [
            'message' => "You are wrong here.\n280 allows equals as neighbors. A one-pass adjacent swap can leave 1,1. Forward interleave of two halves can cluster the median.\nStep back to when you reused 280 or filled each half forward.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'fill' => [
            'message' => "arr = sorted(nums). i = (n−1)//2 (end of the smaller half), j = n−1. For k = 0 .. n−1: even k takes arr[i] then i−=1; odd k takes arr[j] then j−=1. Backward fill keeps equal values from meeting at the median.\nValues 0..5000: a 5001-bucket can dump largest remaining onto odd indices first, then even.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return a new array, or require a unique wave', 'next' => 'wrong_ret'],
                ['label' => 'Mutate nums. O(n log n) sort or O(n) counting', 'next' => 'cpx'],
            ],
        ],
        'wrong_ret' => [
            'message' => "You are wrong. The function mutates nums in place; any valid wave is accepted.\nStep back to when you allocated a result or demanded one unique pattern.",
            'outcome' => 'wrong',
            'rewind_to' => 'fill',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n log n) sort, or O(n) counting. Space O(n) copy, or a 5001-bucket.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse-fill both halves. Strict < >. Not 280', 'next' => 'success'],
                ['label' => 'Put the largest value at index 0 so the wave starts high', 'next' => 'wrong_high'],
            ],
        ],
        'wrong_high' => [
            'message' => "You are wrong. Index 0 is a valley (small). Peaks sit on the odd indices.\nStep back to when you started the wave with a peak.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort, then reverse-fill the small half onto even slots and the large half onto odd slots. Strict peaks. Not 280.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
