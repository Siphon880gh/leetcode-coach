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
            'message' => "Problem: nums is non-decreasing. Return [first, last] index of target, or [-1,-1]. [5,7,7,8,8,10], target = 8 → [3,4]. Empty → [-1,-1]. Must be O(log n). n up to 10^5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Binary-search any hit, then walk left and right while nums[i] == target', 'next' => 'expand'],
                ['label' => 'Two lower bounds: first index of target, and first index of target+1', 'next' => 'bounds'],
            ],
        ],
        'expand' => [
            'message' => "Walking from a hit is O(n) when the array is all target. n = 10^5, so that misses O(log n).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'One binary search is enough: return [mid, mid]', 'next' => 'wrong_mid'],
                ['label' => 'lower_bound(target) and lower_bound(target+1); if they differ, the range is [l, r-1]', 'next' => 'bounds'],
            ],
        ],
        'wrong_mid' => [
            'message' => "You are wrong here.\nA single mid is some occurrence, not necessarily first or last. [5,7,7,8,8,10] with target 8 must return both 3 and 4.\nStep back to when you chose how to get both ends.",
            'outcome' => 'wrong',
            'rewind_to' => 'expand',
            'choices' => [],
        ],
        'bounds' => [
            'message' => "lower_bound(x) is the first i with nums[i] >= x (or n if none). Why search for target+1 instead of a custom “last equal to target” loop?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The first index of a larger value is one past the last target, so last = r-1', 'next' => 'example'],
                ['label' => 'target+1 might not exist as a value, so that search is illegal', 'next' => 'wrong_plus'],
            ],
        ],
        'wrong_plus' => [
            'message' => "You are wrong. You are not looking up the value target+1 in a set. You compare nums[mid] >= target+1, which is valid even if that integer never appears.\nStep back to when you defined the right bound.",
            'outcome' => 'wrong',
            'rewind_to' => 'bounds',
            'choices' => [],
        ],
        'example' => [
            'message' => "[5,7,7,8,8,10], target = 8: l = 3, r = 5, return [3,4]. target = 6: l == r == 1, return [-1,-1]. Empty: both bounds 0.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(log n) time, O(1) extra space', 'next' => 'success'],
                ['label' => 'O(n) because lower_bound still scans equal elements', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. Each lower_bound is a binary search over the full array. Equals do not turn it linear.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. l = lower_bound(target), r = lower_bound(target+1). If l == r, missing; else [l, r-1]. Time O(log n), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
