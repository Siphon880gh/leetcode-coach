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
            'message' => "Problem: length of a longest strictly increasing subsequence (keep order, skip allowed, not a subarray). [10,9,2,5,3,7,101,18] → 4 ([2,3,7,101]). All equal → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat it as Longest Consecutive Sequence (128) or sort then scan consecutive values', 'next' => 'wrong_kind'],
                ['label' => 'DP: f[i] is the best that ends at i; extend from earlier strictly smaller j', 'next' => 'dp'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong here.\n128 hashes values into a consecutive run. Sorting breaks original order. Here you may skip cells but must keep index order, and equals do not extend.\nStep back to when you reused 128 or sorted.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Start every f[i] at 1. For each i, scan j < i: if nums[j] < nums[i], f[i] = max(f[i], f[j] + 1). Answer is max of all f. n = 2500 makes the double loop acceptable.\nFollow-up?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the subsequence itself, or count equals as increasing', 'next' => 'wrong_eq'],
                ['label' => 'O(n log n): tails[len] = smallest ending value of that length; binary search replace or append', 'next' => 'tails'],
            ],
        ],
        'wrong_eq' => [
            'message' => "You are wrong. The prompt asks for the length. Strict: equals never extend ([7,7,7] is 1).\nStep back to when you returned the list or allowed equals.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'tails' => [
            'message' => "Patience sorting: for each x, find the first tail that is >= x and replace it (or append). tails stays sorted; its length is the answer. That is not sorting nums.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n²) end-at-i DP, or O(n log n) tails. Not 128, not contiguous, not equals', 'next' => 'success'],
                ['label' => 'Sort nums first so the tails array is cheaper to build', 'next' => 'wrong_sort'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong. Sorting nums destroys the subsequence order. tails is a helper, not a sorted copy of the input.\nStep back to when you sorted the array.",
            'outcome' => 'wrong',
            'rewind_to' => 'tails',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. f[i] is the best strictly increasing subsequence ending at i. Tails keep the smallest ending value of each length for O(n log n). [10,9,2,5,3,7,101,18] is 4. Equals stay 1.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
